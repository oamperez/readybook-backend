<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('date')->nullable();
            $table->integer('schedule_id')->nullable();
            $table->integer('notify')->default(0);
            $table->longText('detail')->nullable();
            $table->integer('state')->nullable(); // 0 - PENDIENTE | 1 - APROBADA | 2 - RECHAZADA
            $table->longText('reazon')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
