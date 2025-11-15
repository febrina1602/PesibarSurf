<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportDaerah extends Model
{
    protected $table = 'transport_daerah';

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
