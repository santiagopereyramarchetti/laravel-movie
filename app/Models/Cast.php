<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cast extends Model
{
    use HasFactory;

    protected $fillable = [
        'tmdb_id',
        'name',
        'slug',
        'poster_path'
    ];

    //We define a model mutator
    protected function name(): Attribute{

        return Attribute::make(
            set: fn($value) => [
                'name' => $value,
                'slug' => Str::slug($value)
            ],
        );

    }
}
