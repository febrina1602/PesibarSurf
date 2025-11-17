<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penginapan extends Model
{
    protected $fillable = [
        'name',
        'image',
        'location',
        'rating',
        'price_start',
        'description',
        'whatsapp',
    ];
}