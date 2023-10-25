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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');
            $table->string('order_unick_id');
            $table->string('category_name');
            $table->string('name');
            $table->string('phone');
            $table->string('address');
            $table->string('pickup_request_date');
            $table->string('img_url');
            $table->string('voice')->nullable();
            $table->string('order_date');
            $table->string('order_status');
            $table->string('status');
            $table->string('estimated_weight');
            $table->string('eatimated_amount');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
