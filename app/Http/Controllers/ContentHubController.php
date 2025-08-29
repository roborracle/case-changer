<?php

namespace App\Http\Controllers;

use App\Services\QualityMetricsService;
use App\Services\SemanticLinkingService;
use App\Services\TransformationService;
use App\Services\SchemaService;
use Illuminate\Support\Facades\Cache;

class ContentHubController extends Controller
{
    protected QualityMetricsService $metricsService;
    protected SemanticLinkingService $linkingService;
    protected TransformationService $transformationService;
    protected SchemaService $schemaService;
    
    public function __construct(
        QualityMetricsService $metricsService,
        SemanticLinkingService $linkingService,
        TransformationService $transformationService,
        SchemaService $schemaService
    ) {
        $this->metricsService = $metricsService;
        $this->linkingService = $linkingService;
        $this->transformationService = $transformationService;
        $this->schemaService = $schemaService;
    }
    
    /**
     * Display content hub for a specific category
     */
    public function show(string $category)
    {
        $categoryMap = $this->getCategoryMap();
        
        if (!isset($categoryMap[$category])) {
            abort(404);
        }
        
        $categoryData = $categoryMap[$category];
        
        $tools = $this->getToolsByCategory($categoryData['name']);
        
        $metrics = $this->metricsService->getCategoryMetrics($categoryData['name']);
        
        $relatedContent = $this->linkingService->getRelatedContent($category);
        
        $schemaData = $this->generateHubSchema($category, $categoryData, $tools);
        
        $guideContent = $this->getGuideContent($category);
        
        return view('hubs.show', [
            'category' => $category,
            'categoryData' => $categoryData,
            'tools' => $tools,
            'metrics' => $metrics,
            'relatedContent' => $relatedContent,
            'schemaData' => $schemaData,
            'guideContent' => $guideContent
        ]);
    }
    
    /**
     * Get category mapping
     */
    private function getCategoryMap(): array
    {
        return [
            'text-case' => [
                'name' => 'Case Conversion',
                'title' => 'Text Case Conversion Tools Hub',
                'description' => 'Comprehensive guide to text case transformations including uppercase, lowercase, title case, and more.',
                'icon' => '🔤',
                'tools' => ['upper-case', 'lower-case', 'title-case', 'sentence-case', 'alternating-case']
            ],
            'programming-cases' => [
                'name' => 'Programming Cases',
                'title' => 'Programming Case Convention Tools',
                'description' => 'Master programming case conventions: camelCase, PascalCase, snake_case, kebab-case, and more.',
                'icon' => '💻',
                'tools' => ['camel-case', 'pascal-case', 'snake-case', 'kebab-case', 'constant-case', 'dot-case']
            ],
            'encoding' => [
                'name' => 'Encoding & Decoding',
                'title' => 'Text Encoding and Decoding Hub',
                'description' => 'Complete encoding toolkit: Base64, URL encoding, HTML entities, and cryptographic hashing.',
                'icon' => '🔐',
                'tools' => ['base64-encode', 'url-encode', 'html-encode', 'md5-hash', 'sha256-hash']
            ],
            'formatting' => [
                'name' => 'Text Formatting',
                'title' => 'Text Formatting and Styling Hub',
                'description' => 'Format and style text for any platform: JSON, XML, HTML, CSS, and code formatting.',
                'icon' => '📝',
                'tools' => ['json-formatter', 'xml-formatter', 'html-formatter', 'css-formatter', 'javascript-formatter']
            ],
            'generators' => [
                'name' => 'Text Generators',
                'title' => 'Text and Data Generator Tools',
                'description' => 'Generate passwords, UUIDs, lorem ipsum, random data, and more.',
                'icon' => '🎲',
                'tools' => ['password-generator', 'uuid-generator', 'lorem-ipsum', 'username-generator', 'email-generator']
            ],
            'analysis' => [
                'name' => 'Text Analysis',
                'title' => 'Text Analysis and Metrics Hub',
                'description' => 'Analyze text with word counters, readability scores, sentiment analysis, and more.',
                'icon' => '📊',
                'tools' => ['word-frequency', 'reading-time', 'flesch-score', 'sentiment-analysis', 'keyword-extractor']
            ],
            'style-guides' => [
                'name' => 'Style Guides',
                'title' => 'Editorial Style Guide Tools',
                'description' => 'Apply professional editorial styles: AP, Chicago, MLA, APA, and more.',
                'icon' => '📚',
                'tools' => ['ap-style', 'chicago-style', 'mla-style', 'apa-style', 'harvard-style']
            ],
            'social-media' => [
                'name' => 'Social Media',
                'title' => 'Social Media Text Formatting',
                'description' => 'Format text for social media platforms: Twitter, Instagram, LinkedIn, and more.',
                'icon' => '📱',
                'tools' => ['twitter-style', 'instagram-style', 'linkedin-style', 'facebook-style', 'hashtag-style']
            ]
        ];
    }
    
    /**
     * Get tools by category
     */
    private function getToolsByCategory(string $category): array
    {
        return Cache::remember("hub_tools_{$category}", 300, function () use ($category) {
            $transformations = $this->transformationService->getTransformations();
            $categoryTools = [];
            
            foreach ($transformations as $toolId => $toolName) {
                $toolCategory = $this->transformationService->getToolCategory($toolId);
                if ($toolCategory === $category) {
                    $categoryTools[] = [
                        'id' => $toolId,
                        'name' => $toolName,
                        'url' => route('transform') . '?tool=' . $toolId,
                        'metrics' => $this->metricsService->getToolMetrics($toolId)
                    ];
                }
            }
            
            return $categoryTools;
        });
    }
    
    /**
     * Generate comprehensive schema for hub page
     */
    private function generateHubSchema(string $category, array $categoryData, array $tools): array
    {
        $schemas = [];
        
        $schemas[] = [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Home',
                    'item' => url('/')
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Content Hubs',
                    'item' => url('/hubs')
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $categoryData['title'],
                    'item' => url("/hub/{$category}")
                ]
            ]
        ];
        
        $schemas[] = [
            '@type' => 'CollectionPage',
            'name' => $categoryData['title'],
            'description' => $categoryData['description'],
            'url' => url("/hub/{$category}"),
            'mainEntity' => [
                '@type' => 'ItemList',
                'name' => $categoryData['title'] . ' Tools',
                'numberOfItems' => count($tools),
                'itemListElement' => array_map(function ($tool, $index) {
                    return [
                        '@type' => 'SoftwareApplication',
                        'position' => $index + 1,
                        'name' => $tool['name'],
                        'url' => $tool['url'],
                        'applicationCategory' => 'Text Transformation Tool'
                    ];
                }, $tools, array_keys($tools))
            ]
        ];
        
        $schemas[] = [
            '@type' => 'HowTo',
            'name' => 'How to Use ' . $categoryData['title'],
            'description' => 'Step-by-step guide to using ' . strtolower($categoryData['title']),
            'step' => $this->generateHowToSteps($category)
        ];
        
        return $schemas;
    }
    
    /**
     * Generate HowTo steps for schema
     */
    private function generateHowToSteps(string $category): array
    {
        $steps = [
            [
                '@type' => 'HowToStep',
                'name' => 'Choose Your Tool',
                'text' => 'Select the appropriate transformation tool from the category.'
            ],
            [
                '@type' => 'HowToStep',
                'name' => 'Enter Your Text',
                'text' => 'Paste or type your text into the input field.'
            ],
            [
                '@type' => 'HowToStep',
                'name' => 'Apply Transformation',
                'text' => 'Click the transform button or press Enter to apply the conversion.'
            ],
            [
                '@type' => 'HowToStep',
                'name' => 'Copy Result',
                'text' => 'Click the copy button to copy the transformed text to your clipboard.'
            ]
        ];
        
        return $steps;
    }
    
    /**
     * Get guide content for category
     */
    private function getGuideContent(string $category): array
    {
        $guides = [
            'text-case' => [
                'introduction' => 'Text case conversion is fundamental to proper formatting in writing and programming. This comprehensive guide covers all major case conversion methods.',
                'sections' => [
                    [
                        'title' => 'Understanding Text Cases',
                        'content' => 'Text case refers to the capitalization pattern used in written text. Different cases serve different purposes in various contexts.',
                        'examples' => [
                            'UPPERCASE' => 'HELLO WORLD',
                            'lowercase' => 'hello world',
                            'Title Case' => 'Hello World',
                            'Sentence case' => 'Hello world'
                        ]
                    ],
                    [
                        'title' => 'When to Use Each Case',
                        'content' => 'Each text case has specific use cases and conventions in different fields.',
                        'examples' => [
                            'Headlines' => 'Title Case for Professional Documents',
                            'Constants' => 'UPPERCASE_FOR_CONSTANTS',
                            'Variables' => 'lowercase_for_variables',
                            'Sentences' => 'Sentence case for regular text.'
                        ]
                    ]
                ]
            ],
            'programming-cases' => [
                'introduction' => 'Programming case conventions are essential for writing clean, readable code. Each programming language has preferred naming conventions.',
                'sections' => [
                    [
                        'title' => 'Common Programming Cases',
                        'content' => 'Different programming languages and frameworks prefer specific case conventions for variables, functions, and classes.',
                        'examples' => [
                            'camelCase' => 'firstName, lastName, phoneNumber',
                            'PascalCase' => 'UserAccount, DatabaseConnection',
                            'snake_case' => 'user_id, created_at, is_active',
                            'kebab-case' => 'background-color, font-size'
                        ]
                    ]
                ]
            ]
        ];
        
        return $guides[$category] ?? [
            'introduction' => 'Comprehensive guide for ' . $category . ' transformations.',
            'sections' => []
        ];
    }
    
    /**
     * API endpoint for refreshing metrics
     */
    public function metricsApi(string $category)
    {
        $categoryMap = $this->getCategoryMap();
        
        if (!isset($categoryMap[$category])) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        
        $metrics = $this->metricsService->getCategoryMetrics($categoryMap[$category]['name']);
        
        return response()->json([
            'data' => $metrics,
            'timestamp' => now()->toIso8601String()
        ]);
    }
}