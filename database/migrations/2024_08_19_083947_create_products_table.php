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
            $table->uuid('uuid')->primary();
            $table->string('name');
            $table->double('price', 15, 2);
            $table->integer('stock')->nullable();
            $table->string('description')->nullable();
            $table->boolean('available')->default(true);
            $table->string('image_thumbnail')->nullable();
            $table->uuid('category_id');
            $table->timestamps();

            $table->foreign('category_id')->references('uuid')->on('categories')->onDelete('cascade');
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
