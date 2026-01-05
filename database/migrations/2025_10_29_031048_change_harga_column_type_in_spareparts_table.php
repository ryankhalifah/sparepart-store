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
        Schema::table('spareparts', function (Blueprint $table) {
            // Mengubah kolom 'harga' agar bisa menampung angka yang lebih besar
            // (10 digit total, 2 di belakang koma). Sesuai dengan modul.
            $table->decimal('harga', 10, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spareparts', function (Blueprint $table) {
            // Ini mungkin tidak bisa kembali ke tipe data sebelumnya dengan sempurna,
            // tapi ini adalah rollback dasarnya.
            // Sesuaikan (misal 8,2) jika Anda tahu tipe data sebelumnya.
            $table->decimal('harga', 8, 2)->change(); 
        });
    }
};
