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
        Schema::create('validation_audits', function (Blueprint $table) {
            $table->id();
            $table->string('tool_name')->index();
            $table->json('validation_errors')->nullable();
            $table->json('validation_warnings')->nullable();
            $table->json('test_results')->nullable();
            $table->float('execution_time_ms')->default(0);
            $table->bigInteger('memory_usage_bytes')->default(0);
            $table->string('session_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            
            $table->index(['tool_name', 'created_at']);
            $table->index(['validation_status', 'created_at']);
        });
        
        Schema::create('validation_rules', function (Blueprint $table) {
            $table->id();
            $table->string('tool_name')->index();
            $table->json('rule_config');
            $table->boolean('is_active')->default(true);
            $table->integer('priority')->default(0);
            $table->timestamps();
            
            $table->index(['tool_name', 'is_active']);
        });
        
        Schema::create('validation_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_id')->unique();
            $table->timestamp('issued_at');
            $table->timestamp('valid_until');
            $table->json('validation_summary');
            $table->integer('total_tools');
            $table->integer('passed_tools');
            $table->float('success_rate');
            $table->text('signature');
            $table->timestamps();
            
            $table->index('valid_until');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validation_certificates');
        Schema::dropIfExists('validation_rules');
        Schema::dropIfExists('validation_audits');
    }
};
