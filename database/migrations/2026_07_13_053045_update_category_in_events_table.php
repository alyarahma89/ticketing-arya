<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            // 1. Tambahkan kolom category_id yang baru
            // nullable() digunakan agar data event yang sudah ada sebelumnya tidak error
            $table->unsignedBigInteger('category_id')->nullable()->after('image');

            // 2. Jadikan category_id sebagai Foreign Key ke tabel categories
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');

            // 3. Hapus kolom category yang lama (yang berupa teks/varchar)
            $table->dropColumn('category');
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            // Jika di-rollback, kembalikan seperti semula
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
            $table->string('category')->after('image');
        });
    }
};
