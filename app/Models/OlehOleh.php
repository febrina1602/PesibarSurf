<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OlehOleh extends Model
{
    use HasFactory;
    protected $table = 'oleh_oleh';
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
        'price_range',
        'description',
        'whatsapp',
    ];
}