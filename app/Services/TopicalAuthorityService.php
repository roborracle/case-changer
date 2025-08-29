<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\SemanticEntity;

class TopicalAuthorityService
{
    /**
     * Define the semantic content silos and topic hierarchy
     */
    private array $topicHierarchy = [
        'text-transformation' => [
            'label' => 'Text Transformation Tools',
            'description' => 'Comprehensive suite of text conversion and transformation utilities',
            'subtopics' => [
                'case-conversion' => [
                    'label' => 'Case Conversion Tools',
                    'description' => 'Transform text between different letter case formats',
                    'tools' => [
                        'upper-case', 'lower-case', 'title-case', 'sentence-case',
                        'camel-case', 'pascal-case', 'snake-case', 'kebab-case',
                        'constant-case', 'dot-case', 'path-case', 'alternating-case',
                        'inverse-case', 'capitalize-words'
                    ],
                    'related_entities' => ['programming', 'formatting', 'typography']
                ],
                'encoding-transformation' => [
                    'label' => 'Encoding & Decoding Tools',
                    'description' => 'Convert text between different encoding formats',
                    'tools' => [
                        'base64-encode', 'base64-decode', 'url-encode', 'url-decode',
                        'html-encode', 'html-decode', 'ascii-convert', 'unicode-normalize',
                        'binary-text', 'hex-text', 'octal-text', 'morse-code'
                    ],
                    'related_entities' => ['security', 'data-transmission', 'web-development']
                ],
                'string-manipulation' => [
                    'label' => 'String Manipulation Tools',
                    'description' => 'Manipulate and transform text strings',
                    'tools' => [
                        'reverse', 'shuffle-words', 'sort-words', 'remove-spaces',
                        'remove-extra-spaces', 'remove-punctuation', 'extract-letters',
                        'extract-numbers', 'remove-duplicates', 'word-frequency',
                        'truncate-text', 'repeat-text', 'prefix-suffix'
                    ],
                    'related_entities' => ['text-processing', 'data-cleaning', 'automation']
                ],
                'text-formatting' => [
                    'label' => 'Text Formatting Tools',
                    'description' => 'Format text for different platforms and styles',
                    'tools' => [
                        'bold-text', 'italic-text', 'underline-text', 'strikethrough',
                        'smallcaps', 'bubble', 'square', 'script', 'double-struck',
                        'aesthetic', 'sarcasm', 'emoji-case', 'zalgo-text',
                        'upside-down', 'mirror-text', 'wide-text'
                    ],
                    'related_entities' => ['social-media', 'typography', 'design']
                ],
                'content-generation' => [
                    'label' => 'Content Generation Tools',
                    'description' => 'Generate various types of content and identifiers',
                    'tools' => [
                        'lorem-ipsum', 'password-generator', 'uuid-generator',
                        'username-generator', 'email-generator', 'random-number',
                        'random-letter', 'random-date', 'random-month', 'random-ip',
                        'random-choice', 'hex-color', 'phone-number', 'slug-generator'
                    ],
                    'related_entities' => ['development', 'testing', 'mockup-data']
                ],
                'business-formatting' => [
                    'label' => 'Business & Professional Tools',
                    'description' => 'Format text for business and professional contexts',
                    'tools' => [
                        'email-style', 'legal-style', 'marketing-headline', 
                        'press-release', 'memo-style', 'report-style',
                        'proposal-style', 'invoice-style', 'letter-format',
                        'resume-format', 'contract-format'
                    ],
                    'related_entities' => ['business-writing', 'corporate-communication', 'documentation']
                ],
                'academic-citation' => [
                    'label' => 'Academic & Citation Tools',
                    'description' => 'Format text according to academic standards',
                    'tools' => [
                        'apa-style', 'mla-style', 'chicago-author-date', 'chicago-notes',
                        'harvard-style', 'vancouver-style', 'ieee-style', 'ama-style',
                        'bluebook-style', 'turabian-style', 'asa-style', 'aaa-style'
                    ],
                    'related_entities' => ['academic-writing', 'research', 'bibliography']
                ],
                'journalism-style' => [
                    'label' => 'Journalism & Media Tools',
                    'description' => 'Format text for journalism and media',
                    'tools' => [
                        'ap-style', 'nyt-style', 'chicago-style', 'guardian-style',
                        'bbc-style', 'reuters-style', 'economist-style', 'wsj-style',
                        'news-headline', 'subheading-style', 'byline-format'
                    ],
                    'related_entities' => ['journalism', 'media', 'news-writing']
                ]
            ]
        ]
    ];

    /**
     * Entity relationships and semantic connections
     */
    private array $entityRelationships = [
        'upper-case' => ['lower-case', 'title-case', 'constant-case'],
        'camel-case' => ['pascal-case', 'snake-case', 'kebab-case'],
        'base64-encode' => ['base64-decode', 'url-encode', 'html-encode'],
        'lorem-ipsum' => ['random-text', 'placeholder-text', 'dummy-content'],
        'password-generator' => ['uuid-generator', 'random-string', 'secure-token']
    ];

    /**
     * Get the complete topic hierarchy
     */
    public function getTopicHierarchy(): array
    {
        return $this->topicHierarchy;
    }

    /**
     * Get semantic cluster for a specific tool
     */
    public function getToolCluster(string $tool): ?array
    {
        foreach ($this->topicHierarchy['text-transformation']['subtopics'] as $clusterId => $cluster) {
            if (in_array($tool, $cluster['tools'])) {
                return [
                    'cluster_id' => $clusterId,
                    'cluster_label' => $cluster['label'],
                    'cluster_description' => $cluster['description'],
                    'related_tools' => array_diff($cluster['tools'], [$tool]),
                    'related_entities' => $cluster['related_entities']
                ];
            }
        }
        return null;
    }

    /**
     * Calculate semantic similarity between two tools
     */
    public function calculateSimilarity(string $tool1, string $tool2): float
    {
        $cluster1 = $this->getToolCluster($tool1);
        $cluster2 = $this->getToolCluster($tool2);

        if (!$cluster1 || !$cluster2) {
            return 0.0;
        }

        if ($cluster1['cluster_id'] === $cluster2['cluster_id']) {
            return 0.8;
        }

        $sharedEntities = array_intersect(
            $cluster1['related_entities'], 
            $cluster2['related_entities']
        );

        if (count($sharedEntities) > 0) {
            return 0.3 + (count($sharedEntities) * 0.1);
        }

    }

    /**
     * Get semantic breadcrumb path for a tool
     */
    public function getBreadcrumbPath(string $tool): array
    {
        $cluster = $this->getToolCluster($tool);
        
        if (!$cluster) {
            return [];
        }

        $transformationService = new TransformationService();
        $transformations = $transformationService->getTransformations();
        $toolLabel = $transformations[$tool] ?? $tool;

        return [
            [
                'name' => 'Text Transformation Tools',
                'url' => '/',
                'position' => 1
            ],
            [
                'name' => $cluster['cluster_label'],
                'url' => '/' . $cluster['cluster_id'] . '/',
                'position' => 2
            ],
            [
                'name' => $toolLabel,
                'url' => '/' . $cluster['cluster_id'] . '/' . $tool . '/',
                'position' => 3
            ]
        ];
    }

    /**
     * Generate semantic internal links for a tool
     */
    public function getSemanticLinks(string $tool, int $limit = 5): array
    {
        $cluster = $this->getToolCluster($tool);
        
        if (!$cluster) {
            return [];
        }

        $links = [];
        $transformationService = new TransformationService();
        $transformations = $transformationService->getTransformations();

        foreach (array_slice($cluster['related_tools'], 0, $limit) as $relatedTool) {
            $similarity = $this->calculateSimilarity($tool, $relatedTool);
            $links[] = [
                'tool' => $relatedTool,
                'label' => $transformations[$relatedTool] ?? $relatedTool,
                'url' => '/' . $cluster['cluster_id'] . '/' . $relatedTool . '/',
                'relationship' => 'similar',
                'strength' => $similarity
            ];
        }

        if (isset($this->entityRelationships[$tool])) {
            foreach ($this->entityRelationships[$tool] as $related) {
                if (isset($transformations[$related])) {
                    $relatedCluster = $this->getToolCluster($related);
                    $links[] = [
                        'tool' => $related,
                        'label' => $transformations[$related],
                        'url' => '/' . ($relatedCluster['cluster_id'] ?? 'tools') . '/' . $related . '/',
                        'relationship' => 'related',
                        'strength' => 0.9
                    ];
                }
            }
        }

        usort($links, function($a, $b) {
            return $b['strength'] <=> $a['strength'];
        });

        return array_slice($links, 0, $limit);
    }

    /**
     * Generate topic hub page data
     */
    public function getHubPageData(string $clusterId): ?array
    {
        if (!isset($this->topicHierarchy['text-transformation']['subtopics'][$clusterId])) {
            return null;
        }

        $cluster = $this->topicHierarchy['text-transformation']['subtopics'][$clusterId];
        $transformationService = new TransformationService();
        $transformations = $transformationService->getTransformations();

        $tools = [];
        foreach ($cluster['tools'] as $toolId) {
            if (isset($transformations[$toolId])) {
                $tools[] = [
                    'id' => $toolId,
                    'name' => $transformations[$toolId],
                    'url' => '/' . $clusterId . '/' . $toolId . '/',
                    'description' => $this->getToolDescription($toolId)
                ];
            }
        }

        return [
            'cluster_id' => $clusterId,
            'title' => $cluster['label'],
            'description' => $cluster['description'],
            'tools' => $tools,
            'related_entities' => $cluster['related_entities'],
            'breadcrumb' => [
                [
                    'name' => 'Text Transformation Tools',
                    'url' => '/',
                    'position' => 1
                ],
                [
                    'name' => $cluster['label'],
                    'url' => '/' . $clusterId . '/',
                    'position' => 2
                ]
            ]
        ];
    }

    /**
     * Get tool-specific semantic description
     */
    private function getToolDescription(string $tool): string
    {
        $descriptions = [
            'upper-case' => 'Convert text to uppercase letters (CAPITAL LETTERS) for emphasis and formatting',
            'lower-case' => 'Transform text to lowercase letters for consistent formatting',
            'camel-case' => 'Convert text to camelCase format commonly used in programming',
            'snake-case' => 'Transform text to snake_case format used in Python and databases',
            'base64-encode' => 'Encode text or data to Base64 format for safe transmission',
            'lorem-ipsum' => 'Generate Lorem Ipsum placeholder text for design and development',
            'password-generator' => 'Create secure random passwords with customizable complexity'
        ];

        return $descriptions[$tool] ?? 'Transform and convert text with this specialized tool';
    }

    /**
     * Generate semantic FAQ for a tool
     */
    public function getSemanticFAQ(string $tool): array
    {
        $cluster = $this->getToolCluster($tool);
        $transformationService = new TransformationService();
        $transformations = $transformationService->getTransformations();
        $toolName = $transformations[$tool] ?? $tool;

        $faq = [
            [
                'question' => "What is the {$toolName} tool?",
                'answer' => "The {$toolName} tool is a text transformation utility that " . $this->getToolDescription($tool)
            ],
            [
                'question' => "How do I use the {$toolName} converter?",
                'answer' => "Simply paste or type your text in the input field and click the transform button. The tool will instantly convert your text to the desired format."
            ],
            [
                'question' => "Is the {$toolName} tool free to use?",
                'answer' => "Yes, the {$toolName} tool is completely free to use with no limitations on the number of transformations."
            ]
        ];

        if ($cluster) {
            $faq[] = [
                'question' => "What other tools are similar to {$toolName}?",
                'answer' => "Related tools in the {$cluster['cluster_label']} category include " . 
                           implode(', ', array_slice($cluster['related_tools'], 0, 3)) . " and more."
            ];
        }

        return $faq;
    }

    /**
     * Build knowledge graph for entity relationships
     */
    public function buildKnowledgeGraph(): array
    {
        $graph = [
            '@type' => 'WebApplication',
            'name' => 'Case Changer Pro',
            'description' => 'Comprehensive text transformation platform with 172+ tools',
            'applicationCategory' => 'TextEditor',
            'offers' => [
                '@type' => 'Offer',
                'price' => '0',
                'priceCurrency' => 'USD'
            ],
            'hasPart' => []
        ];

        foreach ($this->topicHierarchy['text-transformation']['subtopics'] as $clusterId => $cluster) {
            $clusterNode = [
                '@type' => 'SoftwareApplication',
                '@id' => '#' . $clusterId,
                'name' => $cluster['label'],
                'description' => $cluster['description'],
                'hasPart' => []
            ];

            foreach ($cluster['tools'] as $toolId) {
                $clusterNode['hasPart'][] = [
                    '@type' => 'WebPageElement',
                    '@id' => '#tool-' . $toolId,
                    'name' => $toolId,
                    'isPartOf' => '#' . $clusterId
                ];
            }

            $graph['hasPart'][] = $clusterNode;
        }

        return $graph;
    }
}