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
        Schema::create('analytics_events', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 100)->nullable()->index();
            $table->string('session_id', 100)->index();
            $table->string('event_type', 50)->index();
            $table->json('event_data')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('created_at')->useCurrent()->index();
            
            $table->index(['session_id', 'event_type']);
            $table->index(['user_id', 'created_at']);
        });
        
        Schema::create('analytics_pageviews', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 100)->index();
            $table->string('page_url');
            $table->string('page_title')->nullable();
            $table->string('referrer')->nullable();
            $table->integer('time_on_page')->default(0);
            $table->boolean('bounce')->default(false);
            $table->string('device_type', 20)->nullable();
            $table->string('browser', 50)->nullable();
            $table->string('os', 50)->nullable();
            $table->string('country', 2)->nullable();
            $table->timestamp('created_at')->useCurrent()->index();
            
            $table->index(['page_url', 'created_at']);
            $table->index(['session_id', 'created_at']);
        });
        
        Schema::create('analytics_conversions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 100)->index();
            $table->string('conversion_type', 50)->index();
            $table->string('tool_used', 100)->index();
            $table->integer('input_length')->default(0);
            $table->integer('output_length')->default(0);
            $table->float('processing_time_ms')->default(0);
            $table->boolean('successful')->default(true);
            $table->json('metadata')->nullable();
            $table->timestamp('created_at')->useCurrent()->index();
            
            $table->index(['tool_used', 'created_at']);
            $table->index(['conversion_type', 'successful']);
        });
        
        Schema::create('analytics_performance', function (Blueprint $table) {
            $table->id();
            $table->string('page_url')->index();
            $table->float('load_time')->default(0);
            $table->integer('lighthouse_score')->nullable();
            $table->string('session_id', 100)->nullable();
            $table->timestamp('created_at')->useCurrent()->index();
            
            $table->index(['page_url', 'created_at']);
        });
        
        Schema::create('analytics_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 100)->unique();
            $table->string('user_id', 100)->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referrer_source')->nullable();
            $table->string('referrer_medium')->nullable();
            $table->string('referrer_campaign')->nullable();
            $table->string('device_type', 20)->nullable();
            $table->string('browser', 50)->nullable();
            $table->string('os', 50)->nullable();
            $table->string('country', 2)->nullable();
            $table->string('city', 100)->nullable();
            $table->integer('page_views')->default(0);
            $table->integer('events_count')->default(0);
            $table->integer('duration_seconds')->default(0);
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'started_at']);
            $table->index('started_at');
        });
        
        Schema::create('analytics_daily_metrics', function (Blueprint $table) {
            $table->id();
            $table->date('date')->index();
            $table->string('metric_type', 50)->index();
            $table->string('dimension', 100)->nullable();
            $table->integer('value')->default(0);
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            $table->unique(['date', 'metric_type', 'dimension']);
            $table->index(['date', 'metric_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analytics_daily_metrics');
        Schema::dropIfExists('analytics_sessions');
        Schema::dropIfExists('analytics_performance');
        Schema::dropIfExists('analytics_conversions');
        Schema::dropIfExists('analytics_pageviews');
        Schema::dropIfExists('analytics_events');
    }
};