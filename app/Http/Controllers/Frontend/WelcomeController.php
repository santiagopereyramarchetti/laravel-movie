<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\TvShow;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function index(){
        $genres = Genre::all('id', 'slug', 'title');
        $movies = Movie::with('genres')->get();
        $tvShows = TvShow::withCount('seasons')->get();
        $episodes = Episode::with('season')->get();

        return Inertia::render('Welcome', compact('genres', 'movies', 'tvShows', 'episodes'));
    }
}