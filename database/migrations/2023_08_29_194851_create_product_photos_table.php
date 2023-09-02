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
      Schema::create('product_photos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_product');
        $table->string('url');
        $table->string('description')->nullable();
        $table->integer('width')->nullable();
        $table->integer('height')->nullable();
        $table->timestamps();

        $table->foreign('id_product')->references('id')->on('products')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_photos');
    }
};