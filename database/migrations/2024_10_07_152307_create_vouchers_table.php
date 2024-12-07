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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->string('sku')->unique();
            $table->decimal('discount_amount', 10, 2);
            $table->decimal('min_order_amount', 10, 2);
            $table->integer('usage_limit');
            $table->string('description',255);
            $table->enum('status', ['active', 'expired'])->default('active');
            $table->boolean('is_manually_updated')->default(false);
            $table->tinyInteger('role')->default(1);
            $table->timestamp('start');
            $table->timestamp('end');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
