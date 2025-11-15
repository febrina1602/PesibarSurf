<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OlehOleh extends Model
{
    protected $fillable = [
        'name',
        'image',
        'location',
        'rating',
        'price_range',
        'description',
        'whatsapp',
    ];
}
