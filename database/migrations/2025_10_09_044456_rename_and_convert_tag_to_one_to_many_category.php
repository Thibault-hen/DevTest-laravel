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
        Schema::rename('tag', 'categories');

        Schema::table('quizzes', function (Blueprint $table) {
            $table->uuid('category_id')->nullable()->after('difficulty_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });

        DB::table('quiz_tag')->get()->each(function ($row) {
            DB::table('quiz')
                ->where('id', $row->quiz_id)
                ->update(['category_id' => $row->tag_id]);
        });

        Schema::dropIfExists('quiz_tag');
    }

    public function down(): void
    {
        Schema::create('quiz_tag', function (Blueprint $table) {
            $table->uuid('quiz_id');
            $table->uuid('tag_id');
            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('categories')->onDelete('cascade');
            $table->primary(['quiz_id', 'tag_id']);
        });

        DB::table('quizzes')->whereNotNull('category_id')->get()->each(function ($quiz) {
            DB::table('quiz_tag')->insert([
                'quiz_id' => $quiz->id,
                'tag_id' => $quiz->category_id,
            ]);
        });

        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });

        Schema::rename('categories', 'tag');
    }
};
