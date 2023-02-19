<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Illuminate\Support\Str;

class CastController extends Controller
{
    
    public function index(Request $request){

        $perPage = $request->perPage ?? 5;
        $filters = $request->only('search', 'perPage');

        $casts = Cast::when($request->search, function($castsList, $search) {
            $castsList->where('name', 'like', "%{$search}%");
        })->paginate($perPage)
        ->withQueryString();
        
        return Inertia::render('Casts/Index', compact('casts', 'filters'));
    }

    public function store(Request $request){

        $cast = Cast::where('tmdb_id', $request->castTMDBId)->first();
        if($cast){
            return back()->with('flash.banner', 'Already exists');
        }else{
            $tmdb_cast = Http::get( config('services.tmdb.endpoint').'/person/'. $request->castTMDBId .'?api_key='.config('services.tmdb.secret').'&language=en-US
                        ');
            
            if ($tmdb_cast->successful()) {
                Cast::create([
                    'tmdb_id' => $tmdb_cast['id'],
                    'name'    => $tmdb_cast['name'],
                    'slug'    => Str::slug($tmdb_cast['name']),
                    'poster_path' => $tmdb_cast['profile_path']
                ]);
                return back()->with('flash.banner', 'Cast created');
            }else{
                return back()->with('flash.banner', 'API error');
            }
        }

    }

    public function edit(Cast $cast){

        return Inertia::render('Casts/Edit', compact('cast'));

    }

    public function update(Request $request, Cast $cast){
        $validated = $request->validate([
            'name' => ['required'],
            'poster_path' => ['required']
        ]);

        $cast->update($validated);

        return to_route('admin.casts.index')->with('flash.banner', 'Cast updated');
    }

    public function destroy(Cast $cast){

        $cast->delete();

        return to_route('admin.casts.index')->with('flash.banner', 'Cast deleted');

    }

}
