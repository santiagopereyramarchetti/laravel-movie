<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Season;
use App\Models\TvShow;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TvShowController extends Controller
{
    public function index(){
        $tvShows = TvShow::orderBy('created_at','desc')->paginate(12);
        $genres = Genre::all();
        return Inertia::render('Frontend/TvShows/Index', compact('tvShows', 'genres')); 
    }

    public function show(TvShow $tvShow){
        $genres = Genre::all();
        $tvShow->load('seasons');
        $latests = Movie::orderBy('created_at', 'desc')->take(9)->get();
        return Inertia::render('Frontend/TvShows/Show', compact('tvShow', 'genres', 'latests')); 
    }

    public function seasonShow(TvShow $tvShow, Season $season){
        $genres = Genre::all();
        $season->load('episodes');
        $latests = Movie::orderBy('created_at', 'desc')->take(9)->get();
        return Inertia::render('Frontend/Seasons/Show', compact('tvShow', 'season', 'genres', 'latests')); 
    }

    public function episodeShow(Episode $episode){
        $genres = Genre::all();
        $latests = Movie::orderBy('created_at', 'desc')->take(9)->get();
        $episode->load('season');
        return Inertia::render('Frontend/Episodes/Show', compact('genres', 'episode', 'latests')); 
    }
}
