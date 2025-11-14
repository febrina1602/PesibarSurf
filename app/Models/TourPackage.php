<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'name',
        'description',
        'cover_image_url',
        'thumbnail_images',
        'price_per_person',
        'duration',
        'start_time',
        'end_time',
        'duration_days',
        'duration_nights',
        'availability_period',
        'facilities',
        'destinations_visited',
    ];

    
    protected $casts = [
        'price_per_person' => 'decimal:2',
        'duration_days' => 'integer',
        'duration_nights' => 'integer',
        'thumbnail_images' => 'array', 
    ];

    /**
     * RELASI: Tour Package dimiliki oleh satu Agent
     */
    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }



    /**
     * Accessor untuk facilities - mengubah menjadi array jika JSON atau split jika text
     */
    public function getFacilitiesArrayAttribute()
    {
        if (empty($this->facilities)) {
            return [];
        }
        
        // Jika sudah array, return langsung
        if (is_array($this->facilities)) {
            return $this->facilities;
        }
        
        // decode JSON
        $decoded = json_decode($this->facilities, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $decoded;
        }
        
        // Jika text biasa, split by newline atau comma
        return array_filter(array_map('trim', preg_split('/[\n,]+/', $this->facilities)));
    }

    /**
     * Accessor untuk destinations_visited - mengubah menjadi array
     */
    public function getDestinationsVisitedArrayAttribute()
    {
        if (empty($this->destinations_visited)) {
            return [];
        }
        
        // Cek jika sudah array
        if (is_array($this->destinations_visited)) {
            return $this->destinations_visited;
        }
        
        // decode JSON
        $decoded = json_decode($this->destinations_visited, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $decoded;
        }
        
        // Jika text biasa, split by newline atau comma
        return array_filter(array_map('trim', preg_split('/[\n,]+/', $this->destinations_visited)));
    }

    /**
     * Scope untuk mengambil paket tour dari agent yang sudah diverifikasi
     */
    public function scopeFromVerifiedAgents($query)
    {
        return $query->whereHas('agent', function($q) {
            $q->where('is_verified', true);
        });
    }

    /**
     * Scope untuk mengambil paket tour berdasarkan tipe agent
     */
    public function scopeByAgentType($query, $agentType)
    {
        return $query->whereHas('agent', function($q) use ($agentType) {
            $q->where('agent_type', $agentType);
        });
    }
}

