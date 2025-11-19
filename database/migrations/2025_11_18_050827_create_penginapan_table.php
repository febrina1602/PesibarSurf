<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penginapan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->nullable()->after('id')->constrained('agents')->onDelete('cascade');
            $table->string('name');               // Nama penginapan
            $table->string('image');              // path gambar
            $table->string('location');           // Lokasi, misal: Krui, Pesisir Barat
            $table->decimal('rating', 2, 1)->nullable(); // Rating, misal 4.5
            $table->string('price_start')->nullable();   // Harga mulai, misal: "Rp 250.000/malam"
            $table->text('description')->nullable();     // Deskripsi singkat
            $table->string('whatsapp')->nullable();      // No WA untuk tombol "Hubungi"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penginapan');
    }
};