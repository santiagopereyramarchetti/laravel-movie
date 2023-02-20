<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use App\Models\Season;
use App\Models\TvShow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class EpisodeController extends Controller
{
    public function index(Request $request, TvShow $tvShow, Season $season){
        $perPage = $request->perPage ?? 5;
        $filters = $request->only('search', 'perPage');

        $episodes = Episode::where('season_id', $season->id)->when($request->search, function($episodesList, $search) {
            $episodesList->where('name', 'like', "%{$search}%");
        })->paginate($perPage)
        ->withQueryString();
        
        return Inertia::render('TvShows/Seasons/Episodes/Index', compact('episodes', 'tvShow', 'season', 'filters'));
    }

    public function store(Request $request, TvShow $tvShow, Season $season){
        $episode = $season->episodes()->where('episode_number', $request->episodeNumber)->exists();
        if($episode){
            return back()->with('flash.banner', 'Already exists');
        }else{
            $tmdb_Episode = Http::get( config('services.tmdb.endpoint').'tv/'.  $tvShow->id . '/season/' . $season->id . '/episode/' . $request->episodeNumber . '?api_key='.config('services.tmdb.secret').'&language=en-US');
            if ($tmdb_Episode->successful()) {
                Episode::create([
                    'season_id' => $season->id,
                    'tmdb_id' => $tmdb_Episode['id'],
                    'name'    => $tmdb_Episode['name'],
                    'episode_number' => $tmdb_Episode['episode_number'],
                    'overview' => $tmdb_Episode['overview'],
                ]);
                return back()->with('flash.banner', 'Episode created');
            }else{
                return back()->with('flash.banner', 'API error');
            }
        }
    }

    public function edit(TvShow $tvShow, Season $season, Episode $episode){
        return Inertia::render('TvShows/Seasons/Episodes/Edit', compact('tvShow', 'season', 'episode'));
    }

    public function update(Request $request, TvShow $tvShow, Season $season, Episode $episode){
        $validated = $request->validate([
            'name' => ['required'],
            'overview' => ['required'],
            'is_public' => ['required'],
        ]);

        $episode->update($validated);

        return to_route('admin.episodes.index', [$tvShow->id, $season->id])->with('flash.banner', 'Episode updated');
    }

    public function destroy(TvShow $tvShow, Season $season, Episode $episode){

        $episode->delete();

        return to_route('admin.episodes.index', [$tvShow->id, $season->id])->with('flash.banner', 'Episode deleted');

    }
}
