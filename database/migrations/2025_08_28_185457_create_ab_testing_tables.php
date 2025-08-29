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
        Schema::create('ab_assignments', function (Blueprint $table) {
            $table->id();
            $table->string('experiment_id', 50)->index();
            $table->string('variant', 50);
            $table->string('session_id', 100)->index();
            $table->string('user_agent')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('created_at')->useCurrent();
            
            $table->index(['experiment_id', 'variant']);
            $table->index(['experiment_id', 'created_at']);
        });
        
        Schema::create('ab_conversions', function (Blueprint $table) {
            $table->id();
            $table->string('experiment_id', 50)->index();
            $table->string('variant', 50)->index();
            $table->string('session_id', 100)->index();
            $table->string('user_agent')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
            
            $table->index(['experiment_id', 'variant', 'action']);
            $table->index(['experiment_id', 'created_at']);
        });
        
        Schema::create('ab_experiments', function (Blueprint $table) {
            $table->id();
            $table->string('experiment_id', 50)->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('status', ['draft', 'active', 'paused', 'completed'])->default('draft');
            $table->string('winner')->nullable();
            $table->float('confidence')->default(0);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
            
            $table->index('status');
            $table->index(['status', 'started_at']);
        });
        
        Schema::create('ab_metrics', function (Blueprint $table) {
            $table->id();
            $table->string('experiment_id', 50)->index();
            $table->string('variant', 50)->index();
            $table->date('date')->index();
            $table->integer('views')->default(0);
            $table->integer('conversions')->default(0);
            $table->float('conversion_rate')->default(0);
            $table->integer('bounces')->default(0);
            $table->float('bounce_rate')->default(0);
            $table->float('avg_time_on_site')->default(0);
            $table->integer('tool_uses')->default(0);
            $table->json('custom_metrics')->nullable();
            $table->timestamps();
            
            $table->unique(['experiment_id', 'variant', 'date']);
            $table->index(['experiment_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ab_metrics');
        Schema::dropIfExists('ab_experiments');
        Schema::dropIfExists('ab_conversions');
        Schema::dropIfExists('ab_assignments');
    }
};