<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('kategori_id')->constrained('master_kategori_event')->restrictOnDelete();
            $table->foreignId('benefit_skp_id')->constrained('master_benefit_skp')->restrictOnDelete();
            $table->string('judul_event');
            $table->string('slug')->unique();
            $table->text('deskripsi');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->string('lokasi_atau_platform');
            $table->string('link_pendaftaran');
            $table->string('poster_path')->nullable();
            $table->enum('status_publikasi', ['draft', 'published', 'closed'])->default('published');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};