<?php

use App\Enum\DeleteStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('blood_donation_requsets', function (Blueprint $table) {
            $table->id();
            $table->string('blood_group', 10);
            $table->date('need_before');
            $table->tinyInteger('isConfirm')->default(0);
            $table->string('phone');
            $table->text('message');
            $table->unsignedTinyInteger('deleted')->default(DeleteStatus::NOT_DELETED);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blood_donation_requsets');
    }
};
