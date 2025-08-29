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
        Schema::create('lighthouse_scores', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->integer('performance');
            $table->integer('accessibility');
            $table->integer('best_practices');
            $table->integer('seo');
            $table->integer('pwa')->nullable();
            $table->json('metrics')->nullable();
            $table->timestamps();
            
            $table->index('url');
            $table->index('created_at');
            $table->index(['url', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lighthouse_scores');
    }
};