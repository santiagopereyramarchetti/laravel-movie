<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Genre extends Model
{
    use HasFactory;

        protected $fillable = [
            'tmdb_id',
            'title'
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
