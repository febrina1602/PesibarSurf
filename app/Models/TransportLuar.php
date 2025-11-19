<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportLuar extends Model
{
    use HasFactory;
    protected $table = 'transport_luar';
    protected $guarded = ['id'];

    // Relasi ke User (Agent)
    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

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