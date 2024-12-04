<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users','id');
            $table->foreignId('voucher_id')->constrained('vouchers','id');
            $table->string('order_code', 255)->unique();
            $table->string('name',255);
            $table->string('phone',100);
            $table->string('address',255);
            $table->tinyInteger('payment')->default(1);
            $table->tinyInteger('shipping')->default(1);
            $table->decimal('total_money',10,2);
            $table->integer('status')->default(1);
            $table->tinyInteger('payment_status');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
