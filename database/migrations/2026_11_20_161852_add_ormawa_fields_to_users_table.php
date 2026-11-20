<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kolom role & status akun
            $table->enum('role', ['admin', 'ormawa'])->default('ormawa')->after('password');
            $table->enum('status_akun', ['pending', 'verified', 'rejected'])->default('pending')->after('role');

            // Foreign key ke tabel data master (nullable karena Super Admin tidak terikat fakultas/ormawa)
            $table->foreignId('fakultas_id')
                  ->nullable()
                  ->after('status_akun')
                  ->constrained('master_fakultas')
                  ->nullOnDelete();

            $table->foreignId('jenis_ormawa_id')
                  ->nullable()
                  ->after('fakultas_id')
                  ->constrained('master_jenis_ormawa')
                  ->nullOnDelete();

            // Profil & berkas ormawa
            $table->text('deskripsi_singkat')->nullable()->after('jenis_ormawa_id');
            $table->string('logo_path')->nullable()->after('deskripsi_singkat');
            $table->string('sk_kepengurusan_path')->nullable()->after('logo_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus foreign key terlebih dahulu sebelum menghapus kolomnya
            $table->dropForeign(['fakultas_id']);
            $table->dropForeign(['jenis_ormawa_id']);

            $table->dropColumn([
                'role',
                'status_akun',
                'fakultas_id',
                'jenis_ormawa_id',
                'deskripsi_singkat',
                'logo_path',
                'sk_kepengurusan_path',
            ]);
        });
    }
};