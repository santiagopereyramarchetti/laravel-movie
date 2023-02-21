<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function index(){
        $genres = Genre::all('id', 'slug', 'title');
        return Inertia::render('Welcome', compact('genres'));
    }
}
