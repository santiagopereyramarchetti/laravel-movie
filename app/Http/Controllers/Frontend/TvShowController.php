<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use App\Models\Season;
use App\Models\TvShow;
use Illuminate\Http\Request;

class TvShowController extends Controller
{
    public function index(){

    }

    public function show(TvShow $tvShow){

    }

    public function seasonShow(TvShow $tvShow, Season $season){

    }

    public function episodeShow(Episode $episode){

    }
}
