<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('refund_account')->nullable()->after('payment_status');
            $table->string('refund_reason')->nullable()->after('refund_account');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('refund_account');
            $table->dropColumn('refund_reason');
        });
    }
};
