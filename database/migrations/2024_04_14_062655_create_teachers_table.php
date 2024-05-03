<?php

use App\Enum\DeleteStatus;
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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->integer('t_id')->unique();
            $table->integer('reg')->unique();
            $table->unsignedBigInteger('faculty_id');
            $table->unsignedBigInteger('department_id');
            $table->string('email', 100)->nullable()->unique();
            $table->string('password');
            $table->string('website')->nullable();
            $table->string('name', 50);
            $table->string('phone', 20)->nullable();
            $table->string('blood', 5)->nullable();
            $table->string('address', 200)->nullable();
            $table->string('image_url', 100)->nullable();
            $table->string('cv_link', 100)->nullable();
            $table->text('bio')->nullable();
            $table->string('linkedin', 100)->nullable()->unique();
            $table->string('facebook', 100)->nullable()->unique();
            $table->unsignedTinyInteger('deleted')->default(DeleteStatus::NOT_DELETED);
            $table->foreign('faculty_id')
                ->references('id')
                ->on('faculties')
                ->onDelete('cascade');
            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
