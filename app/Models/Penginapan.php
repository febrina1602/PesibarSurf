<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penginapan extends Model
{
    use HasFactory;
    protected $table = 'penginapan'; // Pastikan nama tabel benar
    protected $guarded = ['id'];

    // Relasi ke User (Agent)
    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
    
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