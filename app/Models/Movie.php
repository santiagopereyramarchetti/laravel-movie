<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Movie extends Model implements Searchable
{
    use HasFactory;

    protected $fillable = [
        'tmdb_id',
        'title',
        'slug',
        'runtime',
        'rating',
        'release_date',
        'lang',
        'video_format',
        'is_public',
        'overview',
        'poster_path',
        'backdrop_path'
    ];

    public function getSearchResult(): SearchResult
    {
        $url = route('movies.show', $this->slug);
     
         return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url
         );
    }

    //We define a model mutator
    protected function title(): Attribute{
        
        return Attribute::make(
            set: fn($value) => [
                'title' => $value,
                'slug' => Str::slug($value)
            ],
        );

    }

    public function genres(){
        return $this->belongsToMany(Genre::class, 'genre_movie');
    }

    public function trailers(){
        return $this->morphMany(TrailerUrl::class, 'trailerable');
    }

    public function tags(){
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function casts(){
        return $this->belongsToMany(Cast::class, 'cast_movie');
    }

}
