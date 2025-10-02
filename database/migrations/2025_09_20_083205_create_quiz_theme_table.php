<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quiz_theme', function (Blueprint $table) {
            $table->id();
            $table->uuid('quiz_id');
            $table->uuid('theme_id');

            $table->foreign('quiz_id')->references('id')->on('quiz')->onDelete('cascade');
            $table->foreign('theme_id')->references('id')->on('theme')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['quiz_id', 'theme_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_theme');
    }
};
