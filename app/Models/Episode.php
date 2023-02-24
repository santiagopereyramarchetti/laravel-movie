<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Episode extends Model implements Searchable
{
    use HasFactory;

    protected $fillable = [
        'tmdb_id',
        'name',
        'slug',
        'season_id',
        'episode_number',
        'is_public',
        'overview',
        'visit'
    ];

    public function getSearchResult(): SearchResult
    {
        $url = route('episodes.show', $this->slug);
     
         return new \Spatie\Searchable\SearchResult(
            $this,
            $this->name,
            $url
         );
    }

    //We define a model mutator
    protected function name(): Attribute{
    
        return Attribute::make(
            set: fn($value) => [
                'name' => $value,
                'slug' => Str::slug($value)
            ],
        );

    }

    public function season(){
        return $this->belongsTo(Season::class);
    }
}
