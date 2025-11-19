<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transport_daerah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->nullable()->after('id')->constrained('agents')->onDelete('cascade');
            $table->string('type');                // mobil, motor, penyeberangan
            $table->string('name');                // Nama agen
            $table->string('image');               // Path gambar, misal: images/transport/mobil-a.png
            $table->string('location');            // Lokasi, misal: Krui, Pesisir Barat
            $table->decimal('rating', 2, 1)->nullable();  // 4.8, 5.0, dll
            $table->string('price_range')->nullable();    // Misal: "Mulai Rp 150.000"
            $table->text('description')->nullable();      // Deskripsi singkat
            $table->string('whatsapp')->nullable();       // Nomor WA
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transport_daerah');
    }
};