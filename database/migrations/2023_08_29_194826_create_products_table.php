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
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        $table->string('title');
        $table->string('status');
        $table->integer('rents')->default(0);
        $table->text('description');
        $table->decimal('price', 10, 2);
        $table->unsignedBigInteger('user_id');

        $table->unsignedBigInteger('created_by')->nullable();
        $table->timestamp('created_at')->nullable();
        $table->unsignedBigInteger('updated_by')->nullable();
        $table->timestamp('updated_at')->nullable();
        $table->softDeletes();
        $table->string('deleted')->default('no');
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