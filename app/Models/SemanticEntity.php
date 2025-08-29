<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SemanticEntity extends Model
{
    protected $fillable = [
        'entity_id',
        'entity_type',
        'name',
        'label',
        'description',
        'cluster_id',
        'semantic_properties',
        'structured_data',
        'meta_title',
        'meta_description',
        'canonical_url',
        'breadcrumb_schema',
        'faq_schema',
        'knowledge_graph'
    ];

    protected $casts = [
        'semantic_properties' => 'array',
        'structured_data' => 'array',
        'breadcrumb_schema' => 'array',
        'faq_schema' => 'array',
        'knowledge_graph' => 'array'
    ];

    /**
     * Get related entities
     */
    public function relatedEntities(): BelongsToMany
    {
        return $this->belongsToMany(
            SemanticEntity::class,
            'semantic_entity_relationships',
            'entity_id',
            'related_entity_id'
        )->withPivot('relationship_type', 'strength', 'bidirectional');
    }

    /**
     * Get entity metrics
     */
    public function metrics(): HasMany
    {
        return $this->hasMany(SemanticEntityMetric::class, 'entity_id', 'entity_id');
    }

    /**
     * Generate JSON-LD structured data for this entity
     */
    public function generateJsonLd(): array
    {
        $jsonLd = [
            '@type' => $this->getSchemaType(),
            '@id' => $this->canonical_url,
            'name' => $this->label,
            'description' => $this->description,
            'url' => $this->canonical_url
        ];

        if ($this->breadcrumb_schema) {
            $jsonLd['breadcrumb'] = $this->generateBreadcrumbJsonLd();
        }

        if ($this->faq_schema) {
            $jsonLd['mainEntity'] = $this->generateFAQJsonLd();
        }

        if ($this->structured_data) {
            $jsonLd = array_merge($jsonLd, $this->structured_data);
        }

        return $jsonLd;
    }

    /**
     * Get schema type based on entity type
     */
    private function getSchemaType(): string
    {
        return match($this->entity_type) {
            'tool' => 'SoftwareApplication',
            'category' => 'CollectionPage',
            'hub' => 'WebPage',
            'guide' => 'HowTo',
            default => 'WebPageElement'
        };
    }

    /**
     * Generate breadcrumb JSON-LD
     */
    private function generateBreadcrumbJsonLd(): array
    {
        $items = [];
        foreach ($this->breadcrumb_schema as $index => $crumb) {
            $items[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $crumb['name'],
                'item' => $crumb['url']
            ];
        }

        return [
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items
        ];
    }

    /**
     * Generate FAQ JSON-LD
     */
    private function generateFAQJsonLd(): array
    {
        $questions = [];
        foreach ($this->faq_schema as $faq) {
            $questions[] = [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer']
                ]
            ];
        }

        return [
            '@type' => 'FAQPage',
            'mainEntity' => $questions
        ];
    }

    /**
     * Calculate semantic distance to another entity
     */
    public function semanticDistance(SemanticEntity $other): float
    {
        if ($this->cluster_id === $other->cluster_id) {
            return 0.2;
        }

        $relationship = $this->relatedEntities()
            ->where('related_entity_id', $other->entity_id)
            ->first();
        
        if ($relationship) {
            return 1.0 - $relationship->pivot->strength;
        }

        return 0.9;
    }

    /**
     * Get recommended related entities
     */
    public function getRecommendations(int $limit = 5): array
    {
        return $this->relatedEntities()
            ->orderBy('semantic_entity_relationships.strength', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($entity) {
                return [
                    'id' => $entity->entity_id,
                    'name' => $entity->label,
                    'url' => $entity->canonical_url,
                    'type' => $entity->pivot->relationship_type,
                    'strength' => $entity->pivot->strength
                ];
            })
            ->toArray();
    }

    /**
     * Update entity metrics
     */
    public function updateMetrics(array $metrics): void
    {
        foreach ($metrics as $key => $value) {
            $this->metrics()->updateOrCreate(
                ['metric_key' => $key],
                [
                    'metric_value' => $value,
                    'updated_at' => now()
                ]
            );
        }
    }

    /**
     * Get entity performance metrics
     */
    public function getPerformanceMetrics(): array
    {
        return $this->metrics()
            ->whereIn('metric_key', ['page_views', 'conversion_rate', 'avg_time_on_page', 'bounce_rate'])
            ->pluck('metric_value', 'metric_key')
            ->toArray();
    }

    /**
     * Build semantic URL for this entity
     */
    public function buildSemanticUrl(): string
    {
        if ($this->entity_type === 'tool') {
            return '/' . $this->cluster_id . '/' . $this->entity_id . '/';
        } elseif ($this->entity_type === 'category') {
            return '/' . $this->cluster_id . '/';
        }
        
        return '/' . $this->entity_id . '/';
    }

    /**
     * Generate meta tags for SEO
     */
    public function generateMetaTags(): array
    {
        $tags = [
            'title' => $this->meta_title ?: $this->label . ' - Case Changer Pro',
            'description' => $this->meta_description ?: $this->description,
            'canonical' => $this->canonical_url,
            'og:title' => $this->meta_title ?: $this->label,
            'og:description' => $this->meta_description ?: $this->description,
            'og:url' => $this->canonical_url,
            'og:type' => $this->entity_type === 'tool' ? 'website' : 'article',
            'twitter:card' => 'summary',
            'twitter:title' => $this->meta_title ?: $this->label,
            'twitter:description' => $this->meta_description ?: $this->description
        ];

        $tags['json-ld'] = json_encode($this->generateJsonLd(), JSON_UNESCAPED_SLASHES);

        return $tags;
    }
}