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
        Schema::create('quiz', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('duration')->default(0);
            $table->string('image_url')->nullable();
            $table->text('image_text')->nullable();
            $table->boolean('is_published')->default(false);
            $table->uuid("author_id");
            $table->uuid('difficulty_id')->nullable();

            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('difficulty_id')->references('id')->on('difficulty')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz');
    }
};
