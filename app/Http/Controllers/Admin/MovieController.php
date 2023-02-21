<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class MovieController extends Controller
{
    public function index(Request $request){
        $perPage = $request->perPage ?? 5;
        $filters = $request->only('search', 'perPage', 'column', 'direction');

        $movies = Movie::when($request->search, function($movieList, $search) {
            $movieList->where('title', 'like', "%{$search}%");
        })
        ->when($request->column, function($movieList, $column) use($request){
            $movieList->orderBy($column, $request->direction);
        })
        ->paginate($perPage)
        ->withQueryString();
        
        return Inertia::render('Movies/Index', compact('movies', 'filters'));
    }

    public function store(Request $request){
        $movie = Movie::where('tmdb_id', $request->movieTMDBId)->exists();
        if($movie){
            return back()->with('flash.banner', 'Already exists');
        }else{
            $tmdb_Movie = Http::get( config('services.tmdb.endpoint').'movie/'. $request->movieTMDBId .'?api_key='.config('services.tmdb.secret').'&language=en-US');
            
            if ($tmdb_Movie->successful()) {
                Movie::create([
                    'tmdb_id' => $tmdb_Movie['id'],
                    'title' => $tmdb_Movie['title'],
                    'runtime' => $tmdb_Movie['runtime'],
                    'rating' => $tmdb_Movie['vote_average'],
                    'release_date' => $tmdb_Movie['release_date'],
                    'lang' => $tmdb_Movie['original_language'],
                    'video_format' => 'HD',
                    'is_public' => false,
                    'overview' => $tmdb_Movie['overview'],
                    'poster_path' => $tmdb_Movie['poster_path'],
                    'backdrop_path' => $tmdb_Movie['backdrop_path']
                ]);
                return back()->with('flash.banner', 'Movie created');
            }else{
                return back()->with('flash.banner', 'API error');
            }
        }
    }

    public function edit(Movie $movie){
        return Inertia::render('Movies/Edit', compact('movie'));
    }

    public function update(Request $request, Movie $movie){
        $validated = $request->validate([
            'title' => 'required',
            'poster_path' => 'required',
            'runtime' => 'required',
            'language' => 'required',
            'video_format' => 'required',
            'rating' => 'required',
            'backdrop_path' => 'required',
            'overview' => 'required',
            'is_public' => 'required'
        ]);

        $movie->update($validated);

        return to_route('admin.movies.index')->with('flash.banner', 'Movie updated');
    }

    public function destroy(Movie $movie){
        $movie->delete();
        return to_route('admin.movies.index')->with('flash.banner', 'Movie deleted');
    }
}
