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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('reg');
            $table->string('phone')->nullable();
            $table->string('linked_in')->nullable();
            $table->string('blood')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->unsignedBigInteger('batch_id');
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('faculty_id');
            $table->string('fb_link')->nullable();
            $table->string('image_url')->nullable();
            $table->string('cv_link', 500)->nullable();
            $table->string('password', 500);
            $table->text('bio')->nullable();
            $table->boolean('deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
