<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class TvShow extends Model  implements Searchable
{
    use HasFactory;

    protected $fillable = ['tmdb_id', 'name', 'slug', 'poster_path', 'created_year'];

    //We define a model mutator
    protected function name(): Attribute{

        return Attribute::make(
            set: fn($value) => [
                'name' => $value,
                'slug' => Str::slug($value)
            ],
        );

    }

    public function getSearchResult(): SearchResult
    {
        $url = route('tvShows.show', $this->slug);
     
         return new \Spatie\Searchable\SearchResult(
            $this,
            $this->name,
            $url
         );
    }

    public function seasons(){
        return $this->HasMany(Season::class);
    }
}
