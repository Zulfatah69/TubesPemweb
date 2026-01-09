<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {

            if (!Schema::hasColumn('bookings', 'midtrans_order_id')) {
                $table->string('midtrans_order_id')->nullable()->after('total_price');
            }

            if (!Schema::hasColumn('bookings', 'snap_token')) {
                $table->string('snap_token')->nullable()->after('midtrans_order_id');
            }

            if (!Schema::hasColumn('bookings', 'payment_type')) {
                $table->string('payment_type')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'midtrans_order_id',
                'snap_token',
                'payment_type',
            ]);
        });
    }
};
