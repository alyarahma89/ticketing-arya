<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sponsorship_transactions', function (Blueprint $table) {
            // Menambahkan kolom status pembayaran setelah kolom status
            $table->string('payment_status')->default('unpaid')->after('status');
        });
    }

    public function down()
    {
        Schema::table('sponsorship_transactions', function (Blueprint $table) {
            $table->dropColumn('payment_status');
        });
    }
};
