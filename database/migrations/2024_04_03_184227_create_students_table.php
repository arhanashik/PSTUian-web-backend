<?php

declare(strict_types=1);

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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('s_id', 20)->unique();
            $table->string('name', 50);
            $table->integer('reg')->unique();
            $table->string('phone', 20)->nullable();
            $table->string('linked_in', 100)->nullable();
            $table->string('blood', 5)->nullable();
            $table->string('address', 200)->nullable();
            $table->string('email', 100)->nullable()->unique();
            $table->unsignedBigInteger('batch_id');
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('faculty_id');
            $table->string('fb_link', 100)->nullable();
            $table->string('image_url', 100)->nullable();
            $table->string('cv_link', 100)->nullable();
            $table->string('password');
            $table->text('bio')->nullable();
            $table->unsignedTinyInteger('deleted')->default(DeleteStatus::NOT_DELETED);
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
