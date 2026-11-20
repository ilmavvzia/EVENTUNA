<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_kategori_event', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori', 50)->unique();
            $table->string('warna_badge', 30)->default('#6366f1');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_kategori_event');
    }
};