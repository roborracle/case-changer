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
        Schema::create('test_harness_runs', function (Blueprint $table) {
            $table->id();
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->enum('status', ['running', 'passed', 'failed', 'error'])->default('running');
            $table->integer('total_tests')->default(0);
            $table->integer('passed_tests')->default(0);
            $table->integer('failed_tests')->default(0);
            $table->integer('warning_tests')->default(0);
            $table->float('execution_time_ms')->nullable();
            $table->float('memory_peak_mb')->nullable();
            $table->json('error_log')->nullable();
            $table->timestamps();
            
            $table->index('status');
            $table->index('created_at');
            $table->index(['status', 'created_at']);
        });
        
        Schema::create('test_harness_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('run_id')->constrained('test_harness_runs')->onDelete('cascade');
            $table->string('tool_name')->index();
            $table->enum('status', ['passed', 'failed', 'warning', 'skipped'])->index();
            $table->float('execution_time')->default(0);
            $table->json('error_message')->nullable();
            $table->json('warning_message')->nullable();
            $table->integer('test_count')->default(0);
            $table->integer('passed_count')->default(0);
            $table->json('test_details')->nullable();
            $table->timestamps();
            
            $table->index(['run_id', 'status']);
            $table->index(['tool_name', 'created_at']);
            $table->index(['tool_name', 'status']);
        });
        
        Schema::create('test_harness_failures', function (Blueprint $table) {
            $table->id();
            $table->string('tool_name')->index();
            $table->json('error_details');
            $table->integer('consecutive_count')->default(1);
            $table->boolean('notification_sent')->default(false);
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
            
            $table->index(['tool_name', 'created_at']);
            $table->index('consecutive_count');
        });
        
        Schema::create('test_harness_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('run_id')->constrained('test_harness_runs')->onDelete('cascade');
            $table->string('recipient');
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->json('notification_data');
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
            
            $table->index('notification_type');
            $table->index('status');
            $table->index(['run_id', 'notification_type']);
        });
        
        Schema::create('test_harness_baselines', function (Blueprint $table) {
            $table->id();
            $table->string('tool_name')->unique();
            $table->float('baseline_time_ms');
            $table->integer('sample_count')->default(10);
            $table->timestamp('last_updated');
            $table->timestamps();
            
            $table->index('tool_name');
        });
        
        Schema::create('test_harness_config', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value');
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->index('key');
        });
        
        DB::table('test_harness_config')->insert([
            [
                'key' => 'enabled',
                'value' => 'true',
                'type' => 'boolean',
                'description' => 'Enable/disable test harness execution',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'schedule_hours',
                'value' => '6',
                'type' => 'integer',
                'description' => 'Hours between scheduled test runs',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'failure_threshold',
                'value' => '5',
                'type' => 'integer',
                'description' => 'Number of failures before sending notifications',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'retention_days',
                'value' => '30',
                'type' => 'integer',
                'description' => 'Days to retain test results',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'timeout_seconds',
                'value' => '1800',
                'type' => 'integer',
                'description' => 'Maximum execution time in seconds',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'notification_channels',
                'value' => json_encode(['email', 'log']),
                'type' => 'json',
                'description' => 'Active notification channels',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_harness_config');
        Schema::dropIfExists('test_harness_baselines');
        Schema::dropIfExists('test_harness_notifications');
        Schema::dropIfExists('test_harness_failures');
        Schema::dropIfExists('test_harness_results');
        Schema::dropIfExists('test_harness_runs');
    }
};