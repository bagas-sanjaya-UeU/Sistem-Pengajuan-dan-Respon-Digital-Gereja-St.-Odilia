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
        Schema::create('respons', function (Blueprint $table) {
            $table->id();
            // Foreign key ke tabel pengajuans untuk mengetahui respon ini untuk pengajuan mana
            $table->foreignId('pengajuan_id')->constrained('pengajuans')->onDelete('cascade');
            // Foreign key ke tabel users untuk mengetahui siapa yang memberi respon (admin/pastor/dll)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('catatan')->nullable(); // Catatan atau komentar dari responden
            $table->string('lampiran_respon')->nullable(); // Path ke file lampiran balasan jika ada
            $table->timestamps(); // created_at akan menjadi tanggal ditanggapi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respons');
    }
};
