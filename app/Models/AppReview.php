<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppReview extends Model
{
    use HasFactory;

    protected $table = 'app_reviews';

    protected $fillable = [
        'user_id',
        'rating',
        'comment',
    ];

    // Relasi ke User (Opsional, jika nanti ingin menampilkan nama pengulas)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}