<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {

            // status pembayaran
            $table->enum('payment_status', ['unpaid','paid','failed'])
                  ->default('unpaid')
                  ->after('status');

            // total harga
            $table->integer('total_price')
                  ->after('months');

            // midtrans
            $table->string('order_id')->nullable()->after('total_price');
            $table->text('snap_token')->nullable()->after('order_id');

            // tambah status paid
            $table->enum('status', ['pending','approved','rejected','paid'])
                  ->default('pending')
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'payment_status',
                'total_price',
                'order_id',
                'snap_token'
            ]);

            $table->enum('status', ['pending','approved','rejected'])
                  ->default('pending')
                  ->change();
        });
    }
};
