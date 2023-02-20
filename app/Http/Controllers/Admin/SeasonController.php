<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Season;
use App\Models\TvShow;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SeasonController extends Controller
{
    public function index(Request $request, TvShow $tvShow){
        $perPage = $request->perPage ?? 5;
        $filters = $request->only('search', 'perPage');

        $seasons = Season::where('tv_show_id', $tvShow->id)->when($request->search, function($seasonList, $search) {
            $seasonList->where('name', 'like', "%{$search}%");
        })->paginate($perPage)
        ->withQueryString();
        
        return Inertia::render('TvShows/Seasons/Index', compact('seasons', 'tvShow', 'filters'));
    }

    public function store(Request $request, TvShow $tvShow){
        $season = $tvShow->seasons()->where('season_number', $request->seasonNumber)->exists();
        if($season){
            return back()->with('flash.banner', 'Already exists');
        }else{
            $tmdb_Season = Http::get( config('services.tmdb.endpoint').'tv/'.  $tvShow->id . '/season/' . $request->seasonNumber .'?api_key='.config('services.tmdb.secret').'&language=en-US');
            
            if ($tmdb_Season->successful()) {
                Season::create([
                    'tv_show_id' => $tvShow->id,
                    'tmdb_id' => $tmdb_Season['id'],
                    'name'    => $tmdb_Season['name'],
                    'poster_path' => $tmdb_Season['poster_path'],
                    'season_number' => $tmdb_Season['season_number'],
                ]);
                return back()->with('flash.banner', 'Season created');
            }else{
                return back()->with('flash.banner', 'API error');
            }
        }
    }

    public function edit(TvShow $tvShow, Season $season){
        return Inertia::render('TvShows/Seasons/Edit', compact('tvShow', 'season'));
    }

    public function update(Request $request, TvShow $tvShow, Season $season){
        $validated = $request->validate([
            'name' => ['required'],
        ]);

        $season->update($validated);

        return to_route('admin.seasons.index', $tvShow->id)->with('flash.banner', 'Seasons updated');
    }

    public function destroy(TvShow $tvShow, Season $season){

        $season->delete();

        return to_route('admin.seasons.index', $tvShow->id)->with('flash.banner', 'Seasons deleted');

    }

}
