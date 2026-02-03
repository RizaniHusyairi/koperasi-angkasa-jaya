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
        Schema::create('pinjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id')->constrained('anggota')->onDelete('cascade');
            $table->decimal('jumlah_pinjaman', 15, 2);
            $table->decimal('sisa_pinjaman', 15, 2);
            $table->integer('tenor'); // Jumlah bulan
            $table->decimal('bunga', 5, 2)->default(0); // Persentase bunga
            $table->date('tanggal_pinjaman');
            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->enum('status', ['Aktif', 'Lunas', 'Menunggak'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjaman');
    }
};
