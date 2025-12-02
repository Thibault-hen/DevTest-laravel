<?php

declare(strict_types=1);

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
        Schema::create('analytics_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('method')->index();
            $table->string('route')->index();
            $table->smallInteger('status_code')->index();
            $table->decimal('duration_ms');
            $table->string('user_agent')->nullable();
            $table->ipAddress('ip_address');
            $table->uuid('user_id')->nullable();
            $table->string('session_id')->index();
            $table->string('visitor_id')->index();
            $table->timestamp('created_at')->useCurrent()->index();
            $table->date('date')->index();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analytics_requests');
    }
};
