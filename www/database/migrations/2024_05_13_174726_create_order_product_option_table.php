<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_product_option', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_product_id');
            $table->bigInteger('option_id');

            $table->foreign('order_product_id')->references('id')->on('order_product')
                ->onDelete('cascade');
            $table->foreign('option_id')->references('id')->on('options')
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_product_option');
    }
};
