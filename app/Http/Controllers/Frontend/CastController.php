<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use App\Models\Genre;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CastController extends Controller
{
    public function index(){
        $casts = Cast::orderBy('created_at','desc')->paginate(12);
        $genres = Genre::all();
        return Inertia::render('Frontend/Casts/Index', compact('genres', 'casts'));
    }

    public function show(Cast $cast){

    }

}
