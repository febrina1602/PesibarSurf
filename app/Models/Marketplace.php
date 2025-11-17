<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marketplace extends Model
{
    protected $fillable = [
        'image',
        'title',
        'description',
        'slug',
        'buttons',
    ];

    protected $casts = [
        'buttons' => 'array',  // otomatis decode JSON → array
    ];
}