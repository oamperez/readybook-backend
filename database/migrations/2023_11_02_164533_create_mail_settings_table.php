<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mail_settings', function (Blueprint $table) {
            $table->id();
            $table->string('MAIL_MAILER')->nullable();
            $table->string('MAIL_HOST')->nullable();
            $table->string('MAIL_PORT')->nullable();
            $table->string('MAIL_USERNAME')->nullable();
            $table->string('MAIL_PASSWORD')->nullable();
            $table->string('MAIL_ENCRYPTION')->nullable();
            $table->string('MAIL_FROM_ADDRESS')->nullable();
            $table->string('MAIL_FROM_NAME')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mail_settings');
    }
};
