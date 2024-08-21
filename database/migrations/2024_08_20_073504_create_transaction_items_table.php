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
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('transaction_id');
            $table->uuid('product_id');
            $table->bigInteger('qty');
            $table->double('sub_total', 15, 2);
            $table->timestamps();

            $table->foreign('transaction_id')->references('uuid')->on('transactions')->onDelete('cascade');
            $table->foreign('product_id')->references('uuid')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_items');
    }
};
