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
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faculty_id');
            $table->string('name');
            $table->string('title')->nullable();
            $table->unsignedBigInteger('academicyear_id');
            $table->unsignedInteger('total_student')->default(0);
            $table->unsignedTinyInteger('deleted')->default(DeleteStatus::NOT_DELETED);
            $table->timestamps();
            $table->foreign('faculty_id')
                ->references('id')
                ->on('faculties')
                ->onDelete('cascade');
            $table->foreign('academicyear_id')
                ->references('id')
                ->on('academic_years')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
