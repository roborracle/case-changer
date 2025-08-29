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
        Schema::create('qa_test_runs', function (Blueprint $table) {
            $table->id();
            $table->string('run_id')->unique()->index();
            $table->enum('status', ['pending', 'running', 'passed', 'failed', 'error'])->default('pending');
            $table->json('options')->nullable();
            $table->json('report')->nullable();
            $table->float('duration_seconds')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->json('error')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'created_at']);
        });
        
        Schema::create('qa_test_cases', function (Blueprint $table) {
            $table->id();
            $table->string('test_id')->unique()->index();
            $table->string('suite');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category')->index();
            $table->json('expected_outcome')->nullable();
            $table->json('test_data')->nullable();
            $table->integer('priority')->default(5);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['suite', 'category']);
        });
        
        Schema::create('qa_test_results', function (Blueprint $table) {
            $table->id();
            $table->string('run_id')->index();
            $table->string('test_id')->nullable();
            $table->string('stage');
            $table->json('results');
            $table->boolean('passed')->default(false);
            $table->float('execution_time')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
            
            $table->index(['run_id', 'stage']);
            $table->index(['test_id', 'passed']);
        });
        
        Schema::create('qa_defects', function (Blueprint $table) {
            $table->id();
            $table->string('defect_id')->unique()->index();
            $table->string('run_id')->nullable();
            $table->string('test_id')->nullable();
            $table->string('title');
            $table->text('description');
            $table->enum('severity', ['critical', 'high', 'medium', 'low'])->default('medium');
            $table->enum('status', ['open', 'in_progress', 'resolved', 'closed', 'wont_fix'])->default('open');
            $table->string('assigned_to')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('discovered_at');
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
            
            $table->index(['severity', 'status']);
            $table->index('discovered_at');
        });
        
        Schema::create('qa_coverage_reports', function (Blueprint $table) {
            $table->id();
            $table->string('run_id')->index();
            $table->string('suite');
            $table->float('coverage_percentage');
            $table->integer('total_statements');
            $table->integer('covered_statements');
            $table->integer('uncovered_statements');
            $table->json('file_coverage')->nullable();
            $table->json('class_coverage')->nullable();
            $table->json('method_coverage')->nullable();
            $table->timestamps();
            
            $table->index(['suite', 'created_at']);
        });
        
        Schema::create('qa_performance_benchmarks', function (Blueprint $table) {
            $table->id();
            $table->string('benchmark_id')->unique()->index();
            $table->string('name');
            $table->string('url');
            $table->json('benchmarks');
            $table->float('requests_per_second')->nullable();
            $table->float('time_per_request')->nullable();
            $table->float('memory_usage')->nullable();
            $table->boolean('is_baseline')->default(false);
            $table->timestamps();
            
            $table->index(['name', 'created_at']);
        });
        
        Schema::create('qa_metrics', function (Blueprint $table) {
            $table->id();
            $table->date('date')->index();
            $table->string('metric_type')->index();
            $table->string('metric_name');
            $table->float('value');
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            $table->unique(['date', 'metric_type', 'metric_name']);
        });
        
        Schema::create('qa_test_suites', function (Blueprint $table) {
            $table->id();
            $table->string('suite_id')->unique()->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->json('configuration')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('priority')->default(5);
            $table->timestamps();
        });
        
        Schema::create('qa_regression_tests', function (Blueprint $table) {
            $table->id();
            $table->string('test_id')->index();
            $table->string('commit_hash')->nullable();
            $table->string('branch')->nullable();
            $table->json('affected_files')->nullable();
            $table->json('test_selection')->nullable();
            $table->boolean('passed')->default(false);
            $table->integer('flaky_count')->default(0);
            $table->timestamps();
            
            $table->index(['test_id', 'passed']);
            $table->index('commit_hash');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qa_regression_tests');
        Schema::dropIfExists('qa_test_suites');
        Schema::dropIfExists('qa_metrics');
        Schema::dropIfExists('qa_performance_benchmarks');
        Schema::dropIfExists('qa_coverage_reports');
        Schema::dropIfExists('qa_defects');
        Schema::dropIfExists('qa_test_results');
        Schema::dropIfExists('qa_test_cases');
        Schema::dropIfExists('qa_test_runs');
    }
};