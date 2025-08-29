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
        Schema::create('semantic_entities', function (Blueprint $table) {
            $table->id();
            $table->string('entity_id')->unique()->index();
            $table->string('name');
            $table->string('label');
            $table->text('description')->nullable();
            $table->string('cluster_id')->nullable()->index();
            $table->json('semantic_properties')->nullable();
            $table->json('structured_data')->nullable();
            $table->string('meta_title', 160)->nullable();
            $table->text('meta_description')->nullable();
            $table->string('canonical_url')->nullable();
            $table->json('breadcrumb_schema')->nullable();
            $table->json('faq_schema')->nullable();
            $table->json('knowledge_graph')->nullable();
            $table->timestamps();
            
            $table->index(['entity_type', 'cluster_id']);
            $table->index(['cluster_id', 'entity_id']);
        });

        Schema::create('semantic_entity_relationships', function (Blueprint $table) {
            $table->id();
            $table->string('entity_id')->index();
            $table->string('related_entity_id')->index();
            $table->boolean('bidirectional')->default(true);
            $table->timestamps();
            
            $table->unique(['entity_id', 'related_entity_id', 'relationship_type'], 'entity_relationship_unique');
            
            $table->foreign('entity_id')->references('entity_id')->on('semantic_entities')->onDelete('cascade');
            $table->foreign('related_entity_id')->references('entity_id')->on('semantic_entities')->onDelete('cascade');
        });

        Schema::create('semantic_entity_metrics', function (Blueprint $table) {
            $table->id();
            $table->string('entity_id')->index();
            $table->string('metric_key')->index();
            $table->float('metric_value');
            $table->date('metric_date')->nullable();
            $table->timestamps();
            
            $table->index(['entity_id', 'metric_key']);
            $table->index(['metric_key', 'metric_date']);
            
            $table->foreign('entity_id')->references('entity_id')->on('semantic_entities')->onDelete('cascade');
        });

        Schema::create('semantic_clusters', function (Blueprint $table) {
            $table->id();
            $table->string('cluster_id')->unique();
            $table->string('cluster_name');
            $table->text('cluster_description')->nullable();
            $table->string('parent_cluster_id')->nullable();
            $table->json('cluster_properties')->nullable();
            $table->integer('entity_count')->default(0);
            $table->integer('priority')->default(0);
            $table->timestamps();
            
            $table->index('parent_cluster_id');
            $table->index('priority');
        });

        Schema::create('semantic_search_index', function (Blueprint $table) {
            $table->id();
            $table->string('entity_id')->index();
            $table->text('searchable_text');
            $table->json('search_keywords')->nullable();
            $table->json('search_synonyms')->nullable();
            $table->float('relevance_score')->default(1.0);
            $table->integer('search_count')->default(0);
            $table->timestamps();
            
            $table->index('relevance_score');
            
            $table->foreign('entity_id')->references('entity_id')->on('semantic_entities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semantic_search_index');
        Schema::dropIfExists('semantic_clusters');
        Schema::dropIfExists('semantic_entity_metrics');
        Schema::dropIfExists('semantic_entity_relationships');
        Schema::dropIfExists('semantic_entities');
    }
};
