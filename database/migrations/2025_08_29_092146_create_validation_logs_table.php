<?php

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
        Schema::create('validation_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tool_id')->nullable();
            $table->string('tool_name');
            $table->string('validation_type');
            $table->string('severity');
            $table->string('input_hash')->nullable();
            $table->string('output_hash')->nullable();
            $table->json('validation_rules')->nullable();
            $table->unsignedInteger('execution_time_ms')->nullable();
            $table->unsignedBigInteger('memory_usage_bytes')->nullable();
            $table->text('error_message')->nullable();
            $table->string('error_code')->nullable();
            $table->text('stack_trace')->nullable();
            $table->json('context_data')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('session_id')->nullable();
            $table->timestamps();

            $table->index(['tool_name', 'created_at']);
            $table->index(['severity', 'created_at']);
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validation_logs');
    }
};
