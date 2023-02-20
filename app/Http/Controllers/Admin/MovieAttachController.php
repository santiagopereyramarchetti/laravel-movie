<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use App\Models\Movie;
use App\Models\Tag;
use App\Models\TrailerUrl;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MovieAttachController extends Controller
{
    public function index(Movie $movie){
        $trailers = $movie->trailers;
        $casts = Cast::all('id', 'name');
        $tags = Tag::all('id', 'tag_name');
        $movieCasts = $movie->casts;
        $movieTags = $movie->tags;
        return Inertia::render('Movies/Attach', compact('movie', 'trailers', 'casts', 'tags', 'movieCasts', 'movieTags'));
    }

    public function addTrailer(Request $request, Movie $movie){
        $validated = $request->validate([
            'name' => 'required',
            'embed_html' => 'required'
        ]);
        $movie->trailers()->create($validated);

        return redirect()->back()->with('flash.banner', 'Trailer Added');
    }

    public function destroyTrailer(TrailerUrl $trailer_url){
        $trailer_url->delete();
        return redirect()->back()->with('flash.banner', 'Trailer Deleted');
    }

    public function addCasts(Request $request, Movie $movie){
        $cast_ids = collect($request->casts)->pluck('id');
        $movie->casts()->sync($cast_ids);
        return redirect()->back()->with('flash.banner', 'Casts Added');
    }

    public function addTags(Request $request, Movie $movie){
        $tag_ids = collect($request->tags)->pluck('id');
        $movie->tags()->sync($tag_ids);
        return redirect()->back()->with('flash.banner', 'Tags Added');
    }
}
