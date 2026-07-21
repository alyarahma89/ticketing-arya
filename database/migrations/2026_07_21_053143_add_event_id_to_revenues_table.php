<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan perintah ini untuk menambahkan kolom.
     */
    public function up(): void
    {
        Schema::table('revenues', function (Blueprint $table) {
            // Menambahkan kolom event_id
            // nullable() digunakan agar data lama tidak error jika kolom ini awalnya kosong
            $table->foreignId('event_id')->nullable()->after('id')->constrained('events')->cascadeOnDelete();
        });
    }

    /**
     * Jalankan perintah ini jika ingin membatalkan (menghapus kolom).
     */
    public function down(): void
    {
        Schema::table('revenues', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropColumn('event_id');
        });
    }
};
