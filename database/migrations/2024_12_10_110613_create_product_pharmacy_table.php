<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_pharmacy', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('pharmacy_id');
            $table->decimal('price', 10, 2); // Store the price at the pharmacy for the product
            $table->timestamps();

            // Foreign keys
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('pharmacy_id')->references('id')->on('pharmacies')->onDelete('cascade');

            // Indexes (for performance)
            $table->index('product_id');
            $table->index('pharmacy_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_pharmacy');
    }
};
