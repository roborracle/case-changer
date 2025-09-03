<?php

namespace App\Services;

class SchemaService
{
    private string $baseUrl;
    
    public function __construct()
    {
        $this->baseUrl = config('app.url', 'https://casechangerpro.com');
    }
    
    /**
     * Generate WebSite schema for homepage
     */
    public function generateWebSiteSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => $this->baseUrl . '/#website',
            'url' => $this->baseUrl,
            'name' => 'Case Changer Pro',
            'description' => 'Professional text transformation suite with 172 conversion tools across 18 specialized categories for developers, writers, academics, and content creators',
            'publisher' => [
                '@id' => $this->baseUrl . '/#organization'
            ],
            'author' => [
                '@id' => 'https://robertdavidorr.com/#person'
            ],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => $this->baseUrl . '/search?q={search_term_string}'
                ],
                'query-input' => 'required name=search_term_string'
            ],
            'inLanguage' => 'en-US',
            'copyrightYear' => 2024,
            'copyrightHolder' => [
                '@id' => 'https://robertdavidorr.com/#person'
            ]
        ];
    }

    /**
     * Generate Person schema for author
     */
    public function generatePersonSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            '@id' => 'https://robertdavidorr.com/#person',
            'name' => 'Robert David Orr',
            'givenName' => 'Robert',
            'additionalName' => 'David',
            'familyName' => 'Orr',
            'url' => 'https://robertdavidorr.com',
            'sameAs' => [
                'https://github.com/roborracle',
                'https://linkedin.com/in/robertdavidorr',
                'https://twitter.com/roborracle'
            ],
            'knowsAbout' => [
                'Software Development',
                'Text Processing',
                'Developer Tools',
                'Web Applications'
            ]
        ];
    }

    /**
     * Generate SoftwareApplication schema
     */
    public function generateSoftwareApplicationSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'SoftwareApplication',
            '@id' => $this->baseUrl . '/#software',
            'name' => 'Case Changer Pro',
            'applicationCategory' => 'DeveloperApplication',
            'operatingSystem' => 'Any',
            'offers' => [
                '@type' => 'Offer',
                'price' => '0',
                'priceCurrency' => 'USD'
            ]
        ];
    }

    /**
     * Generate WebApplication schema
     */
    public function generateWebApplicationSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebApplication',
            '@id' => $this->baseUrl . '/#software',
            'name' => 'Case Changer Pro',
            'description' => 'Free online text transformation toolkit',
            'applicationCategory' => 'DeveloperApplication',
            'operatingSystem' => 'Any',
            'browserRequirements' => 'Requires JavaScript. Requires HTML5.',
            'permissions' => 'No special permissions required',
            'offers' => [
                '@type' => 'Offer',
                'price' => '0',
                'priceCurrency' => 'USD',
                'availability' => 'https://schema.org/InStock'
            ],
            'featureList' => [
                'Case conversion (uppercase, lowercase, title case, etc.)',
                'Developer formats (camelCase, snake_case, kebab-case)',
                'Text transformations',
                'Pattern conversions',
                'Smart formatting',
                'Batch processing',
                'Real-time preview',
                'Copy to clipboard',
                'No registration required',
                'Free to use'
            ],
            'screenshot' => [],
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => '5',
                'ratingCount' => '1'
            ]
        ];
    }

    /**
     * Generate Organization schema
     */
    public function generateOrganizationSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            '@id' => $this->baseUrl . '/#organization',
            'name' => 'Case Changer Pro',
            'url' => $this->baseUrl,
            'logo' => [
                '@type' => 'ImageObject',
                'url' => $this->baseUrl . '/images/logo.png',
                'width' => 512,
                'height' => 512
            ],
            'founder' => [
                '@id' => 'https://robertdavidorr.com/#person'
            ],
            'foundingDate' => '2024',
            'sameAs' => [
                'https://github.com/roborracle/case-changer'
            ]
        ];
    }

    /**
     * Generate BreadcrumbList schema
     */
    public function generateBreadcrumbSchema(array $items = []): array
    {
        $breadcrumb = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Home',
                    'item' => $this->baseUrl . '/'
                ]
            ]
        ];

        $position = 2;
        foreach ($items as $item) {
            $breadcrumb['itemListElement'][] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $item['name'],
                'item' => $item['url'] ?? null
            ];
        }

        return $breadcrumb;
    }

    /**
     * Generate Collection schema for category pages
     */
    public function generateCollectionSchema(string $category, array $categoryData): array
    {
        $collection = [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            '@id' => $this->baseUrl . "/conversions/{$category}#collection",
            'name' => $categoryData['title'],
            'description' => $categoryData['description'],
            'url' => $this->baseUrl . "/conversions/{$category}",
            'isPartOf' => [
                '@id' => $this->baseUrl . '/#website'
            ],
            'breadcrumb' => [
                '@id' => '#breadcrumb'
            ],
            'hasPart' => []
        ];

        foreach ($categoryData['tools'] as $tool) {
            $toolId = $tool['id'] ?? str_replace(' ', '-', strtolower($tool['name']));
            $collection['hasPart'][] = [
                '@type' => 'SoftwareApplication',
                'name' => $tool['name'],
                'description' => $tool['description'],
                'url' => $this->baseUrl . "/conversions/{$category}/{$toolId}#tool"
            ];
        }

        return $collection;
    }

    /**
     * Generate Tool schema for individual tool pages
     */
    public function generateToolSchema(string $category, string $tool, array $toolData): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebApplication',
            '@id' => $this->baseUrl . "/conversions/{$category}/{$tool}#tool",
            'name' => $toolData['name'] . ' - Case Changer Pro',
            'description' => $toolData['description'] ?? "Transform text using {$toolData['name']} with Case Changer Pro's free online tool",
            'url' => $this->baseUrl . "/conversions/{$category}/{$tool}",
            'isPartOf' => [
                '@id' => $this->baseUrl . '/#software'
            ],
            'applicationCategory' => 'UtilityApplication',
            'operatingSystem' => 'Any',
            'permissions' => 'No special permissions required',
            'browserRequirements' => 'Requires JavaScript. Requires HTML5.',
            'offers' => [
                '@type' => 'Offer',
                'price' => '0',
                'priceCurrency' => 'USD'
            ],
            'featureList' => $toolData['features'] ?? [
                'Real-time text transformation',
                'Copy to clipboard',
                'No registration required',
                'Free to use'
            ],
            'potentialAction' => [
                '@type' => 'UseAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => $this->baseUrl . "/conversions/{$category}/{$tool}",
                    'actionPlatform' => [
                        'https://schema.org/DesktopWebPlatform',
                        'https://schema.org/MobileWebPlatform'
                    ]
                ],
                'object' => [
                    '@type' => 'Text',
                    'name' => 'Input text'
                ],
                'result' => [
                    '@type' => 'Text',
                    'name' => 'Transformed text'
                ]
            ]
        ];
    }

    /**
     * Generate FAQ schema
     */
    public function generateFAQSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            '@id' => $this->baseUrl . '/faq#faqpage',
            'name' => 'Frequently Asked Questions - Case Changer Pro',
            'mainEntity' => [
                [
                    '@type' => 'Question',
                    'name' => 'What is Case Changer Pro?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Case Changer Pro is a comprehensive online text transformation toolkit offering 172 conversion tools across 18 specialized categories. It\'s designed for developers, writers, academics, and content creators who need professional text formatting capabilities.'
                    ]
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Is Case Changer Pro free to use?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Yes, Case Changer Pro is completely free to use. All tools are available without registration, payment, or limitations.'
                    ]
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Do I need to create an account?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'No, you don\'t need to create an account. All tools are instantly accessible without any registration.'
                    ]
                ],
                [
                    '@type' => 'Question',
                    'name' => 'What types of text transformations are available?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'We offer case conversions (uppercase, lowercase, title case), developer formats (camelCase, snake_case), academic styles (APA, MLA, Chicago), creative formats, business formats, and many more specialized transformations.'
                    ]
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Is my text data private and secure?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Yes, all text processing happens locally in your browser. Your text is never sent to our servers, ensuring complete privacy and security.'
                    ]
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Can I use Case Changer Pro for commercial purposes?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Yes, you can use Case Changer Pro for both personal and commercial purposes without any restrictions.'
                    ]
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Does it work on mobile devices?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Yes, Case Changer Pro is fully responsive and works on all devices including smartphones, tablets, and desktop computers.'
                    ]
                ],
                [
                    '@type' => 'Question',
                    'name' => 'How do I report a bug or suggest a feature?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'You can report bugs or suggest features through our contact page or by reaching out via our GitHub repository.'
                    ]
                ]
            ]
        ];
    }

    /**
     * Generate SiteNavigationElement schema
     */
    public function generateNavigationSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'SiteNavigationElement',
            '@id' => $this->baseUrl . '/#navigation',
            'name' => 'Main Navigation',
            'hasPart' => [
                [
                    '@type' => 'WebPage',
                    'name' => 'Home',
                    'url' => $this->baseUrl . '/'
                ],
                [
                    '@type' => 'CollectionPage',
                    'name' => 'All Tools',
                    'url' => $this->baseUrl . '/conversions'
                ],
                [
                    '@type' => 'ItemList',
                    'name' => 'Categories',
                    'url' => $this->baseUrl . '/conversions'
                ],
                [
                    '@type' => 'WebPage',
                    'name' => 'FAQ',
                    'url' => $this->baseUrl . '/faq'
                ],
                [
                    '@type' => 'WebPage',
                    'name' => 'About',
                    'url' => $this->baseUrl . '/about'
                ]
            ]
        ];
    }

    /**
     * Combine all homepage schemas
     */
    public function getHomepageSchemas(): array
    {
        return [
            $this->generateWebSiteSchema(),
            $this->generateWebApplicationSchema(),
            $this->generateOrganizationSchema(),
            $this->generatePersonSchema(),
            $this->generateNavigationSchema(),
            $this->generateFAQSchema()
        ];
    }

    /**
     * Get schemas for category page
     */
    public function getCategorySchemas(string $category, array $categoryData): array
    {
        $breadcrumbs = $this->generateBreadcrumbSchema([
            ['name' => 'Tools', 'url' => $this->baseUrl . '/conversions'],
            ['name' => $categoryData['name']]
        ]);

        return [
            $this->generateCollectionSchema($category, $categoryData),
            $breadcrumbs
        ];
    }

    /**
     * Get schemas for tool page
     */
    public function getToolSchemas(string $category, string $tool, array $categoryData, array $toolData): array
    {
        $breadcrumbs = $this->generateBreadcrumbSchema([
            ['name' => 'Tools', 'url' => $this->baseUrl . '/conversions'],
            ['name' => $categoryData['title'], 'url' => $this->baseUrl . "/conversions/{$category}"],
            ['name' => $toolData['name']]
        ]);

        return [
            $this->generateToolSchema($category, $tool, $toolData),
            $breadcrumbs
        ];
    }
}