<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marketplaces', function (Blueprint $table) {
            $table->id();
            $table->string('image');             // path icon image, contoh: assets/marketplace/transportasi.png
            $table->string('title');             // contoh: Transportasi
            $table->string('description');       // contoh: Dapatkan transportasi yang kamu inginkan
            $table->string('slug')->unique();    // contoh: transportasi
            $table->json('buttons')->nullable(); // label-button disimpan sebagai array JSON
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marketplaces');
    }
};