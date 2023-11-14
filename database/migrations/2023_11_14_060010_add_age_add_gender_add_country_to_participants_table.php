<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->integer('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('country')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->dropColumn('age');
            $table->dropColumn('gender');
            $table->dropColumn('country');
        });
    }
};
