<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use App\Models\Genre;
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

    }

    public function seasonShow(TvShow $tvShow, Season $season){

    }

    public function episodeShow(Episode $episode){

    }
}
