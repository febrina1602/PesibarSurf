<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transport_luar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->nullable()->after('id')->constrained('agents')->onDelete('cascade');
            $table->string('type');                // travel, bus
            $table->string('name');                // Nama agen
            $table->string('image');               // Path gambar
            $table->string('location');            // Lokasi, misal: Pesibar - Bandar Lampung
            $table->decimal('rating', 2, 1)->nullable();
            $table->string('price_range')->nullable();    // Kisaran tarif
            $table->text('description')->nullable();
            $table->string('whatsapp')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transport_luar');
    }
};