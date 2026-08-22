<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Menambahkan kolom event_id ke tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id')->nullable()->after('role');
            // Membuat relasi agar jika event dihapus, data event_id di user menjadi null (aman)
            $table->foreign('event_id')->references('id')->on('events')->onDelete('set null');
        });

        // 2. Menambahkan kolom secret_code ke tabel events
        Schema::table('events', function (Blueprint $table) {
            $table->string('secret_code')->nullable()->unique()->after('quota');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropColumn('event_id');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('secret_code');
        });
    }
};
