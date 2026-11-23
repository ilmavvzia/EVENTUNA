<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_paket_events', function (Blueprint $table) {
            $table->id();$table->foreignId('kategori_id')->constrained('master_kategori_event')->cascadeOnDelete();
            $table->foreignId('benefit_skp_id')->constrained('master_benefit_skp')->cascadeOnDelete();$table->foreignId('fakultas_id')->constrained('master_fakultas')->cascadeOnDelete();
            $table->foreignId('jenis_ormawa_id')->constrained('master_jenis_ormawa')->cascadeOnDelete();$table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_paket_events');
    }
};