<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class GenreController extends Controller
{
    public function index(Request $request){

        $perPage = $request->perPage ?? 5;
        $filters = $request->only('search', 'perPage');

        $genres = Genre::when($request->search, function($genreList, $search) {
            $genreList->where('title', 'like', "%{$search}%");
        })->paginate($perPage)
        ->withQueryString();
        
        return Inertia::render('Genres/Index', compact('genres', 'filters'));
    }

    public function store(Request $request){

        $tmdb_genres = Http::get( config('services.tmdb.endpoint').'genre/movie/list?api_key='.config('services.tmdb.secret').'&language=en-US');
        if($tmdb_genres->successful()){
            $tmdb_genres = $tmdb_genres->json();
            foreach($tmdb_genres as $tmdb_genre){
                foreach($tmdb_genre as $genre){
                    $genreDb = Genre::where('tmdb_id', $genre['id'])->first();
                    if(!$genreDb){
                        Genre::create([
                            'tmdb_id' => $genre['id'],
                            'title' => $genre['name']
                        ]);
                    }
                }
            }
            return redirect()->back()->with('flash.banner', 'Genres created');
        }else{
            return redirect()->back()->with('flash.banner', 'API error');     
        }

    }

    public function edit(Genre $genre){
        return Inertia::render('Genres/Edit', compact('genre'));
    }

    public function update(Request $request, Genre $genre){
        $validated = $request->validate([
           'title' => 'required' 
        ]);
        $genre->update($validated);
        return to_route('admin.genres.index')->with('flash.banner', 'Genres updated');
    }

    public function destroy(Genre $genre){
        $genre->delete();
        return to_route('admin.genres.index')->with('flash.banner', 'Genre deleted');
    }

}
