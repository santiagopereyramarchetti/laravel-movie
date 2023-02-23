<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Tag;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TagController extends Controller
{
    public function show(Tag $tag){
        
        $genres = Genre::all();

        $movies = $tag->movies()->paginate(12);

        return Inertia::render('Frontend/Tags/Index', compact('genres', 'tag', 'movies'));
    }
}
