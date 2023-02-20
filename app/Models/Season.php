<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Season extends Model
{
    use HasFactory;

    protected $fillable = ['tv_show_id', 'tmdb_id', 'name', 'slug', 'poster_path', 'season_number'];

    //We define a model mutator
    protected function name(): Attribute{
        
        return Attribute::make(
            set: fn($value) => [
                'name' => $value,
                'slug' => Str::slug($value)
            ],
        );

    }

    public function episodes(){
        return $this->hasMany(Episode::class);
    }
}
