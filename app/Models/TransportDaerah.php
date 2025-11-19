<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportDaerah extends Model
{
    use HasFactory;
    protected $table = 'transport_daerah';
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