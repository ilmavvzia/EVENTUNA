<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom pelacakan status approval event oleh Admin.
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->enum('status_approval', ['pending', 'approved', 'rejected'])
                  ->default('pending')
                  ->after('status_publikasi');

            $table->foreignId('approved_by')
                  ->nullable()
                  ->after('status_approval')
                  ->constrained('users')
                  ->nullOnDelete();

            $table->text('catatan_penolakan')
                  ->nullable()
                  ->after('approved_by');

            $table->timestamp('waktu_keputusan')
                  ->nullable()
                  ->after('catatan_penolakan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn([
                'status_approval',
                'approved_by',
                'catatan_penolakan',
                'waktu_keputusan',
            ]);
        });
    }
};
