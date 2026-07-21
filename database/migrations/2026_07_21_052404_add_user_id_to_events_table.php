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
        Schema::table('events', function (Blueprint $table) {
            // Menambahkan kolom user_id setelah kolom id
            // Kita beri 'nullable()' agar tidak error jika sudah ada data event sebelumnya
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->cascadeOnDelete();
        });
    }

    /**
     * Jalankan perintah ini jika ingin membatalkan (menghapus kolom).
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Memutuskan relasi dan menghapus kolom user_id
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
