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
        Schema::create('tableau_links', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul untuk visualisasi
            $table->text('embed_code'); // Kolom untuk menyimpan seluruh kode embed dari Tableau
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tableau_links');
    }
};
