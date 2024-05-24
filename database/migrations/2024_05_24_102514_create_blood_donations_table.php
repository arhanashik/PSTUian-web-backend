<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('blood_donations', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('user_type', 50);
            $table->foreignId('request_id')->references('id')->on('blood_donation_requsets');
            $table->dateTime('date')->default(now());
            $table->string('info', 500)->nullable();
            $table->tinyInteger('deleted')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blood_donations');
    }
};
