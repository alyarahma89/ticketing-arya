<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Mengubah kolom payment_status menjadi string dengan panjang maksimal 50 karakter
            $table->string('payment_status', 50)->change();
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Mengembalikan ke aturan semula jika diperlukan (bisa disesuaikan dengan tipe aslimu)
            $table->string('payment_status', 20)->change();
        });
    }
};
