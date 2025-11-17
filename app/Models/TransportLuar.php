<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportLuar extends Model
{
    protected $table = 'transport_luar';

    protected $fillable = [
        'type',
        'name',
        'image',
        'location',
        'rating',
        'price_range',
        'description',
        'whatsapp',
    ];
}