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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('slug',255);
            $table->string('image',255)->nullable();
            $table->string('name',255);
            $table->string('sku',255);
            $table->decimal('price', 10, 2);
            $table->decimal('sale', 10, 2)->nullable();
            $table->text('short_description');
            $table->text('long_description');
            $table->string('author',255);
            $table->string('publisher',255);
            $table->integer('released');
            $table->string('weight',255);
            $table->integer('page');
            $table->tinyInteger('best')->default(0);
            $table->tinyInteger('active')->default(1);
            $table->integer('order')->default(1);
            $table->integer('quantity');
            $table->timestamps(); 
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};