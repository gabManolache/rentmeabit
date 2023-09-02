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
        Schema::create('user_feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('target_user_id');
            $table->unsignedBigInteger('feedback_user_id');
            $table->integer('rating')->nullable();  // Ad esempio, da 1 a 5
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->foreign('target_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('feedback_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_feedback');
    }
};
