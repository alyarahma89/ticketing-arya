<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sponsorship_transactions', function (Blueprint $table) {
            $table->id();
            // Menghubungkan pengajuan ini dengan paket sponsor mana
            $table->foreignId('sponsorship_id')->constrained()->cascadeOnDelete();
            // Menghubungkan pengajuan ini dengan akun (user) perusahaan yang mendaftar
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Data Perusahaan
            $table->string('company_name');
            $table->string('company_email');
            $table->string('company_phone');
            $table->text('message')->nullable(); // Pesan tambahan untuk EO

            // Status pengajuan
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sponsorship_transactions');
    }
};
