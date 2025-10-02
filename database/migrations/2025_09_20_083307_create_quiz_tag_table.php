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
        Schema::create('quiz_tag', function (Blueprint $table) {
            $table->id();
            $table->uuid('quiz_id');
            $table->uuid('tag_id');

            $table->foreign('quiz_id')->references('id')->on('quiz')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tag')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['quiz_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_tag');
    }
};
