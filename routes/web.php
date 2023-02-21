<?php

use App\Http\Controllers\Admin\CastController;
use App\Http\Controllers\Admin\EpisodeController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\MovieAttachController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\SeasonController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TvShowController;
use App\Http\Controllers\Frontend\CastController as FrontendCastController;
use App\Http\Controllers\Frontend\GenreController as FrontendGenreController;
use App\Http\Controllers\Frontend\MovieController as FrontendMovieController;
use App\Http\Controllers\Frontend\TvShowController as FrontendTvShowController;
use App\Http\Controllers\Frontend\WelcomeController;
use App\Models\TrailerUrl;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [WelcomeController::class, 'index']);
Route::get('/movies', [FrontendMovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie:slug}', [FrontendMovieController::class, 'show'])->name('movies.show');
Route::get('/tv-shows', [FrontendTvShowController::class, 'index'])->name('tvShows.index');
Route::get('/tv-shows/{TvShow:slug}', [FrontendTvShowController::class, 'show'])->name('tvShows.show');
Route::get('/tv-shows/{TvShow:slug}/seasons/{season:slug}', [FrontendTvShowController::class, 'seasonShow'])->name('season.show');
Route::get('/episodes/{episode:slug}', [FrontendTvShowController::class, 'showEpisode'])->name('episodes.show');
Route::get( '/casts', [FrontendCastController::class, 'index'])->name('casts.index');
Route::get('/casts/{cast:slug}', [FrontendCastController::class, 'show'])->name('casts.show');
Route::get('/genre/{genre:slug}', [FrontendGenreController::class, 'show'])->name('genres.show');

// middleware()->['auth:sanctum', 'verified', 'role:admin']
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function() {
        return Inertia::render('Admin/Index');
    })->name('index');
    Route::resource('/movies', MovieController::class);
    Route::get('/movies/{movie}/attach', [MovieAttachController::class, 'index'])->name('movies.attach');
    Route::post('/movies/{movie}/add-trailer', [MovieAttachController::class, 'addTrailer'])->name('movies.add.trailer');
    Route::delete('/trailer-urls/{trailer_url}', [MovieAttachController::class, 'destroyTrailer'])->name('trailer-urls.destroy');
    Route::post('/movies/{movie}/add-casts', [MovieAttachController::class, 'addCasts'])->name('movies.add.casts');
    Route::post('/movies/{movie}/add-tags', [MovieAttachController::class, 'addTags'])->name('movies.add.tags');
    Route::resource('/tv-shows', TvShowController::class);
    Route::resource('/tv-shows/{tvShow}/seasons', SeasonController::class);
    Route::resource('/tv-shows/{tvShow}/seasons/{season}/episodes', EpisodeController::class);
    Route::resource('/genres', GenreController::class);
    Route::resource('/casts', CastController::class);
    Route::resource('/tags', TagController::class);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
