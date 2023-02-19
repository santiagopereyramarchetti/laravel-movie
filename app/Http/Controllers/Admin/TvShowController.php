<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TvShow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Illuminate\Support\Str;

class TvShowController extends Controller
{
    public function index(Request $request){
        $perPage = $request->perPage ?? 5;
        $filters = $request->only('search', 'perPage');

        $tvShows = TvShow::when($request->search, function($tvShowList, $search) {
            $tvShowList->where('name', 'like', "%{$search}%");
        })->paginate($perPage)
        ->withQueryString();
        
        return Inertia::render('TvShows/Index', compact('tvShows', 'filters'));
    }

    public function store(Request $request){

        $tvShow = TvShow::where('tmdb_id', $request->tvShowTMDBId)->first();
        if($tvShow){
            return back()->with('flash.banner', 'Already exists');
        }else{
            $tmdb_TvShow = Http::get( config('services.tmdb.endpoint').'tv/'. $request->tvShowTMDBId .'?api_key='.config('services.tmdb.secret').'&language=en-US');
            
            if ($tmdb_TvShow->successful()) {
                TvShow::create([
                    'tmdb_id' => $tmdb_TvShow['id'],
                    'name'    => $tmdb_TvShow['name'],
                    'poster_path' => $tmdb_TvShow['poster_path'],
                    'created_year' => $tmdb_TvShow['first_air_date'],
                ]);
                return back()->with('flash.banner', 'TvShow created');
            }else{
                return back()->with('flash.banner', 'API error');
            }
        }

    }

    public function edit(TvShow $tvShow){

        return Inertia::render('TvShows/Edit', compact('tvShow'));

    }

    public function update(Request $request, TvShow $tvShow){
        $validated = $request->validate([
            'name' => ['required'],
        ]);

        $tvShow->update($validated);

        return to_route('admin.tv-shows.index')->with('flash.banner', 'Tv Show updated');
    }

    public function destroy(TvShow $tvShow){

        $tvShow->delete();

        return to_route('admin.tv-shows.index')->with('flash.banner', 'Tv Show deleted');

    }
}
