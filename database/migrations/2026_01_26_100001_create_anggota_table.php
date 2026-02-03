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
        Schema::create('anggota', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nomor_anggota')->unique();
            $table->integer('nomor_urut');
            $table->date('tanggal_gabung');
            $table->string('kode_sp', 10)->default('SP');
            $table->enum('status_pegawai', ['PNS', 'P3K', 'PPNPN'])->default('PNS');
            $table->enum('status_keanggotaan', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->decimal('limit_pinjaman', 15, 2)->default(0);
            $table->decimal('simpanan_pokok', 15, 2)->default(0);
            $table->decimal('simpanan_wajib', 15, 2)->default(0);
            $table->decimal('jumlah_belanja_minimarket', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota');
    }
};
