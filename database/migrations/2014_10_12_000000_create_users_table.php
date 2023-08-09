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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->unique();
            $table->string('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('address_one')->nullable();
            $table->string('address_two')->nullable();
            $table->string('pin')->nullable();
            $table->string('save_for')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('location_url')->nullable();
            $table->string('password')->nullable();
            $table->string('user_type');
            $table->string('alt_phone')->nullable();
            $table->string('image_url')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('image_id')->references('id')->on('images');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
