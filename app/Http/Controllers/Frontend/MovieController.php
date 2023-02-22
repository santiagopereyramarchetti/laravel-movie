<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MovieController extends Controller
{
    public function index(){
        $movies = Movie::with('genres')->orderBy('created_at','desc')->paginate(12);
        $genres = Genre::all();
        return Inertia::render('Frontend/Movies/Index', compact('movies', 'genres')); 
    }

    public function show(Movie $movie){

    }
}
