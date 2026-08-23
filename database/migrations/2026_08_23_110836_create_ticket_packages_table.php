<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_packages', function (Blueprint $table) {
            $table->id();

            // Tali pengikat ke tabel events
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');

            // Detail Paket Tiket
            $table->string('name'); // Contoh: "Reguler", "VIP", "Presale 1"
            $table->integer('price'); // Harga tiketnya (0 jika gratis)
            $table->text('description')->nullable(); // Fasilitas yang didapat (opsional)
            $table->integer('quota'); // Kuota khusus untuk paket ini

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_packages');
    }
};
