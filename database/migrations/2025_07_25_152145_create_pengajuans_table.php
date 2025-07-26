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
        Schema::create('pengajuans', function (Blueprint $table) {
           $table->id();
            // Foreign key ke tabel users untuk mengetahui siapa pemohon
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nomor_pengajuan')->unique(); // Nomor unik untuk setiap pengajuan
            $table->string('jenis_pengajuan');
            $table->text('deskripsi');
            $table->string('lampiran')->nullable(); // Path ke file lampiran jika ada
            // Status untuk melacak proses pengajuan
            $table->enum('status', ['Menunggu', 'Diterima', 'Ditolak', 'Revisi'])->default('Menunggu');
            $table->timestamps(); // created_at akan menjadi tanggal pengajuan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
