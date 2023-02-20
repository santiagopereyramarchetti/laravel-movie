<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Movie extends Model
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

    //We define a model mutator
    protected function title(): Attribute{
        
        return Attribute::make(
            set: fn($value) => [
                'title' => $value,
                'slug' => Str::slug($value)
            ],
        );

    }
}
