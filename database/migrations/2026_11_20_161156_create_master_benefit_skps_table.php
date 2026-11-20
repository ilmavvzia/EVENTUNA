<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_benefit_skp', function (Blueprint $table) {
            $table->id();
            $table->string('nama_benefit', 100);
            $table->integer('bobot_poin')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_benefit_skp');
    }
};