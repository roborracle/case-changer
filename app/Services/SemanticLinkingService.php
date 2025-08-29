<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class SemanticLinkingService
{
    private TransformationService $transformationService;
    
    /**
     * Define semantic relationships between tools
     */
    private array $relationships = [
        'primary' => [
            'upper-case' => ['lower-case', 'title-case', 'sentence-case'],
            'lower-case' => ['upper-case', 'title-case', 'sentence-case'],
            'camel-case' => ['pascal-case', 'snake-case', 'kebab-case'],
            'snake-case' => ['camel-case', 'kebab-case', 'constant-case'],
            'base64-encode' => ['base64-decode', 'url-encode', 'html-encode'],
            'md5-hash' => ['sha256-hash', 'sha1-hash', 'bcrypt-hash'],
            'json-formatter' => ['json-minify', 'json-validator', 'csv-to-json'],
            'password-generator' => ['uuid-generator', 'username-generator', 'api-key-generator']
        ],
        'secondary' => [
            'reverse' => ['mirror-text', 'upside-down', 'backwards-text'],
            'bold' => ['italic', 'underline', 'strikethrough'],
            'twitter-style' => ['instagram-style', 'facebook-style', 'linkedin-style'],
            'ap-style' => ['chicago-style', 'mla-style', 'apa-style'],
            'lorem-ipsum' => ['random-text', 'placeholder-text', 'dummy-data']
        ],
        'use_case' => [
            'json-formatter' => ['api-docs', 'technical-spec', 'config-files'],
            'snake-case' => ['python-case', 'ruby-case', 'database-fields'],
            'camel-case' => ['javascript-case', 'java-case', 'variable-names'],
            'upper-case' => ['constant-case', 'sql-case', 'environment-vars'],
            'url-encode' => ['query-params', 'api-calls', 'web-forms'],
            'base64-encode' => ['data-uri', 'authentication', 'file-encoding']
        ]
    ];
    
    /**
     * Category relationships for content hubs
     */
    private array $categoryRelationships = [
        'text-case' => ['programming-cases', 'style-guides', 'formatting'],
        'programming-cases' => ['text-case', 'api-docs', 'code-formatting'],
        'encoding' => ['security', 'api-integration', 'data-transfer'],
        'formatting' => ['programming-cases', 'documentation', 'data-structures'],
        'generators' => ['security', 'testing', 'development-tools'],
        'analysis' => ['content-optimization', 'seo-tools', 'writing-assistance'],
        'style-guides' => ['academic-writing', 'journalism', 'content-creation'],
        'social-media' => ['marketing', 'content-creation', 'branding']
    ];
    
    public function __construct()
    {
        $this->transformationService = new TransformationService();
    }
    
    /**
     * Get related content for a category or tool
     */
    public function getRelatedContent(string $identifier): array
    {
        return Cache::remember("related_content_{$identifier}", 3600, function () use ($identifier) {
            $related = [
                'primary_tools' => [],
                'secondary_tools' => [],
                'use_cases' => [],
                'related_categories' => [],
                'tutorials' => [],
                'external_resources' => []
            ];
            
            if (isset($this->categoryRelationships[$identifier])) {
                $related['related_categories'] = $this->getRelatedCategories($identifier);
                $related['primary_tools'] = $this->getTopToolsForCategory($identifier);
                $related['tutorials'] = $this->getTutorials($identifier);
            }
            
            if (isset($this->relationships['primary'][$identifier])) {
                $related['primary_tools'] = $this->getPrimaryRelated($identifier);
                $related['secondary_tools'] = $this->getSecondaryRelated($identifier);
                $related['use_cases'] = $this->getUseCases($identifier);
            }
            
            $related['external_resources'] = $this->getExternalResources($identifier);
            
            return $related;
        });
    }
    
    /**
     * Get breadcrumb path for a tool or category
     */
    public function getBreadcrumbs(string $identifier): array
    {
        $breadcrumbs = [
            ['name' => 'Home', 'url' => '/']
        ];
        
        $transformations = $this->transformationService->getTransformations();
        
        if (isset($transformations[$identifier])) {
            $category = $this->transformationService->getToolCategory($identifier);
            $breadcrumbs[] = ['name' => 'Tools', 'url' => '/tools'];
            $breadcrumbs[] = ['name' => $category, 'url' => "/hub/" . $this->slugify($category)];
            $breadcrumbs[] = ['name' => $transformations[$identifier], 'url' => null];
        } else {
            $breadcrumbs[] = ['name' => 'Content Hubs', 'url' => '/hubs'];
            $breadcrumbs[] = ['name' => $this->getCategoryTitle($identifier), 'url' => null];
        }
        
        return $breadcrumbs;
    }
    
    /**
     * Build internal link structure for SEO
     */
    public function buildInternalLinks(string $content, string $currentPage): string
    {
        $transformations = $this->transformationService->getTransformations();
        
        foreach ($transformations as $toolId => $toolName) {
            $patterns = [
                '/' . preg_quote($toolName, '/') . '(?![^<]*>)/i',
                '/' . preg_quote(str_replace('-', ' ', $toolId), '/') . '(?![^<]*>)/i'
            ];
            
            foreach ($patterns as $pattern) {
                $replacement = sprintf(
                    '<a href="%s" title="%s Tool">%s</a>',
                    route('transform') . '?tool=' . $toolId,
                    $toolName,
                    '$0'
                );
                
                $content = preg_replace($pattern, $replacement, $content, 1);
            }
        }
        
        return $content;
    }
    
    /**
     * Get related categories
     */
    private function getRelatedCategories(string $category): array
    {
        $related = [];
        
        if (isset($this->categoryRelationships[$category])) {
            foreach ($this->categoryRelationships[$category] as $relatedCategory) {
                $related[] = [
                    'id' => $relatedCategory,
                    'name' => $this->getCategoryTitle($relatedCategory),
                    'url' => '/hub/' . $relatedCategory,
                    'description' => $this->getCategoryDescription($relatedCategory)
                ];
            }
        }
        
        return $related;
    }
    
    /**
     * Get primary related tools
     */
    private function getPrimaryRelated(string $toolId): array
    {
        $related = [];
        $transformations = $this->transformationService->getTransformations();
        
        if (isset($this->relationships['primary'][$toolId])) {
            foreach ($this->relationships['primary'][$toolId] as $relatedId) {
                if (isset($transformations[$relatedId])) {
                    $related[] = [
                        'id' => $relatedId,
                        'name' => $transformations[$relatedId],
                        'url' => route('transform') . '?tool=' . $relatedId,
                        'relationship' => 'primary'
                    ];
                }
            }
        }
        
        return $related;
    }
    
    /**
     * Get secondary related tools
     */
    private function getSecondaryRelated(string $toolId): array
    {
        $related = [];
        $transformations = $this->transformationService->getTransformations();
        
        if (isset($this->relationships['secondary'][$toolId])) {
            foreach ($this->relationships['secondary'][$toolId] as $relatedId) {
                if (isset($transformations[$relatedId])) {
                    $related[] = [
                        'id' => $relatedId,
                        'name' => $transformations[$relatedId],
                        'url' => route('transform') . '?tool=' . $relatedId,
                        'relationship' => 'secondary'
                    ];
                }
            }
        }
        
        return $related;
    }
    
    /**
     * Get use cases for a tool
     */
    private function getUseCases(string $toolId): array
    {
        $useCases = [];
        
        if (isset($this->relationships['use_case'][$toolId])) {
            foreach ($this->relationships['use_case'][$toolId] as $useCase) {
                $useCases[] = [
                    'title' => $this->formatUseCase($useCase),
                    'description' => $this->getUseCaseDescription($toolId, $useCase),
                    'example' => $this->getUseCaseExample($toolId, $useCase)
                ];
            }
        }
        
        return $useCases;
    }
    
    /**
     * Get top tools for a category
     */
    private function getTopToolsForCategory(string $category): array
    {
        $tools = [];
        $transformations = $this->transformationService->getTransformations();
        
        $categoryTools = $this->getCategoryTools($category);
        
        foreach ($categoryTools as $toolId) {
            if (isset($transformations[$toolId])) {
                $tools[] = [
                    'id' => $toolId,
                    'name' => $transformations[$toolId],
                    'url' => route('transform') . '?tool=' . $toolId
                ];
            }
        }
        
    }
    
    /**
     * Get tutorials for a category
     */
    private function getTutorials(string $category): array
    {
        $tutorials = [
            'text-case' => [
                ['title' => 'Complete Guide to Text Case Conversion', 'url' => '#guide-text-case'],
                ['title' => 'When to Use Each Text Case', 'url' => '#when-to-use'],
                ['title' => 'Text Case in Different Industries', 'url' => '#industries']
            ],
            'programming-cases' => [
                ['title' => 'Programming Naming Conventions', 'url' => '#naming-conventions'],
                ['title' => 'Language-Specific Case Standards', 'url' => '#language-standards'],
                ['title' => 'Best Practices for Variable Names', 'url' => '#best-practices']
            ],
            'encoding' => [
                ['title' => 'Understanding Text Encoding', 'url' => '#encoding-basics'],
                ['title' => 'Security and Encoding', 'url' => '#security'],
                ['title' => 'Choosing the Right Encoding', 'url' => '#choosing-encoding']
            ]
        ];
        
        return $tutorials[$category] ?? [];
    }
    
    /**
     * Get external resources
     */
    private function getExternalResources(string $identifier): array
    {
        return [
        ];
    }
    
    /**
     * Helper: Get category title
     */
    private function getCategoryTitle(string $category): string
    {
        $titles = [
            'text-case' => 'Text Case Conversion',
            'programming-cases' => 'Programming Cases',
            'encoding' => 'Encoding & Decoding',
            'formatting' => 'Text Formatting',
            'generators' => 'Text Generators',
            'analysis' => 'Text Analysis',
            'style-guides' => 'Style Guides',
            'social-media' => 'Social Media'
        ];
        
        return $titles[$category] ?? ucfirst(str_replace('-', ' ', $category));
    }
    
    /**
     * Helper: Get category description
     */
    private function getCategoryDescription(string $category): string
    {
        $descriptions = [
            'text-case' => 'Convert text between uppercase, lowercase, title case, and more.',
            'programming-cases' => 'Transform text for programming conventions like camelCase and snake_case.',
            'encoding' => 'Encode and decode text for various formats and protocols.',
            'formatting' => 'Format text for different file types and data structures.',
            'generators' => 'Generate passwords, UUIDs, lorem ipsum, and other text.',
            'analysis' => 'Analyze text readability, sentiment, and extract insights.',
            'style-guides' => 'Apply professional editorial and academic style guides.',
            'social-media' => 'Format text for social media platforms and marketing.'
        ];
        
        return $descriptions[$category] ?? '';
    }
    
    /**
     * Helper: Get category tools
     */
    private function getCategoryTools(string $category): array
    {
        $categoryTools = [
            'text-case' => ['upper-case', 'lower-case', 'title-case', 'sentence-case', 'alternating-case'],
            'programming-cases' => ['camel-case', 'pascal-case', 'snake-case', 'kebab-case', 'constant-case'],
            'encoding' => ['base64-encode', 'url-encode', 'html-encode', 'md5-hash', 'sha256-hash'],
            'formatting' => ['json-formatter', 'xml-formatter', 'html-formatter', 'css-formatter'],
            'generators' => ['password-generator', 'uuid-generator', 'lorem-ipsum', 'username-generator']
        ];
        
        return $categoryTools[$category] ?? [];
    }
    
    /**
     * Helper: Format use case name
     */
    private function formatUseCase(string $useCase): string
    {
        return ucwords(str_replace(['-', '_'], ' ', $useCase));
    }
    
    /**
     * Helper: Get use case description
     */
    private function getUseCaseDescription(string $toolId, string $useCase): string
    {
        $descriptions = [
            'json-formatter' => [
                'api-docs' => 'Format JSON responses for API documentation.',
                'technical-spec' => 'Structure technical specifications in readable JSON.',
                'config-files' => 'Format configuration files for applications.'
            ],
            'snake-case' => [
                'python-case' => 'Convert variable names for Python programming.',
                'ruby-case' => 'Format identifiers for Ruby conventions.',
                'database-fields' => 'Name database columns consistently.'
            ]
        ];
        
        return $descriptions[$toolId][$useCase] ?? '';
    }
    
    /**
     * Helper: Get use case example
     */
    private function getUseCaseExample(string $toolId, string $useCase): string
    {
        $examples = [
            'json-formatter' => [
                'api-docs' => '{"status":"success","data":{"id":1,"name":"Example"}}',
                'technical-spec' => '{"version":"1.0","features":["auth","api","dashboard"]}',
                'config-files' => '{"database":{"host":"localhost","port":3306}}'
            ],
            'snake-case' => [
                'python-case' => 'user_id, first_name, last_modified_date',
                'ruby-case' => 'attr_accessor, before_action, has_many',
                'database-fields' => 'created_at, updated_at, is_active'
            ]
        ];
        
        return $examples[$toolId][$useCase] ?? '';
    }
    
    /**
     * Helper: Slugify string
     */
    private function slugify(string $text): string
    {
        $text = preg_replace('/[^\w\s-]/', '', $text);
        $text = strtolower(trim($text));
        $text = preg_replace('/[-\s]+/', '-', $text);
        return $text;
    }
}