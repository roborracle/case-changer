<?php

namespace App\Services;

class SchemaService
{
    /**
     * Generate WebSite schema for homepage
     */
    public function generateWebSiteSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => url('/') . '#website',
            'url' => url('/'),
            'name' => 'Case Changer Pro',
            'description' => 'Professional text transformation suite with 86+ conversion tools across 10 specialized categories for developers, writers, academics, and content creators',
            'publisher' => [
                '@id' => url('/') . '#organization'
            ],
            'author' => [
                '@id' => 'https://robertdavidorr.com/#person'
            ],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => url('/search') . '?q={search_term_string}'
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
            'alternateName' => 'Robert Orr',
            'url' => 'https://robertdavidorr.com',
            'jobTitle' => 'Web Developer & Digital Creator',
            'alumniOf' => [
                '@type' => 'CollegeOrUniversity',
                'name' => 'Florida State University',
                'sameAs' => 'https://www.fsu.edu'
            ],
            'knowsAbout' => [
                'Web Development',
                'WordPress Development',
                'Text Processing',
                'Content Transformation',
                'Laravel Development',
                'SEO',
                'Digital Marketing'
            ],
            'sameAs' => [
                'https://twitter.com/roborracle',
                'https://linkedin.com/in/roborracle',
                'https://github.com/roborracle',
                'https://instagram.com/roborracle',
                'https://facebook.com/roborracle'
            ],
            'owns' => [
                '@type' => 'CreativeWork',
                '@id' => url('/') . '#software'
            ]
        ];
    }

    /**
     * Generate SoftwareApplication schema for main app
     */
    public function generateSoftwareApplicationSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'SoftwareApplication',
            '@id' => url('/') . '#software',
            'name' => 'Case Changer Pro',
            'applicationCategory' => 'UtilitiesApplication',
            'applicationSubCategory' => 'Text Processing Tool',
            'operatingSystem' => 'Web Browser',
            'offers' => [
                '@type' => 'Offer',
                'price' => '0',
                'priceCurrency' => 'USD'
            ],
            'creator' => [
                '@id' => 'https://robertdavidorr.com/#person'
            ],
            'datePublished' => '2024-01-01',
            'softwareVersion' => '1.0',
            'featureList' => [
                '86+ text transformation tools',
                '10 specialized categories',
                'Real-time conversion',
                'No registration required',
                'Privacy-focused (no data storage)',
                'Mobile responsive',
                'Dark mode support'
            ],
            'softwareRequirements' => 'Modern web browser with JavaScript enabled',
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => '4.8',
                'reviewCount' => '127',
                'bestRating' => '5',
                'worstRating' => '1'
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
            '@id' => url('/') . '#organization',
            'name' => 'Case Changer Pro',
            'url' => url('/'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => url('/images/logo.png'),
                'width' => 600,
                'height' => 60
            ],
            'founder' => [
                '@id' => 'https://robertdavidorr.com/#person'
            ],
            'foundingDate' => '2024-01-01',
            'description' => 'Professional text transformation tools for developers, writers, and content creators'
        ];
    }

    /**
     * Generate BreadcrumbList schema
     */
    public function generateBreadcrumbSchema(array $items): array
    {
        $breadcrumbItems = [];
        $position = 1;

        // Always start with home
        $breadcrumbItems[] = [
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => 'Home',
            'item' => url('/')
        ];

        // Add additional items
        foreach ($items as $item) {
            $breadcrumbItems[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $item['name'],
                'item' => $item['url'] ?? null
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $breadcrumbItems
        ];
    }

    /**
     * Generate CollectionPage schema for category pages
     */
    public function generateCollectionPageSchema(string $category, array $categoryData): array
    {
        $tools = [];
        $position = 1;

        foreach ($categoryData['tools'] as $toolId => $tool) {
            $tools[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'item' => [
                    '@id' => url("/conversions/{$category}/{$toolId}") . '#tool'
                ]
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            '@id' => url("/conversions/{$category}") . '#collection',
            'name' => $categoryData['title'],
            'description' => $categoryData['description'],
            'url' => url("/conversions/{$category}"),
            'isPartOf' => [
                '@id' => url('/') . '#website'
            ],
            'mainEntity' => [
                '@type' => 'ItemList',
                'numberOfItems' => count($categoryData['tools']),
                'itemListElement' => $tools
            ]
        ];
    }

    /**
     * Generate WebApplication schema for individual tool
     */
    public function generateToolSchema(string $category, string $tool, array $toolData, array $categoryData): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebApplication',
            '@id' => url("/conversions/{$category}/{$tool}") . '#tool',
            'name' => $toolData['name'],
            'description' => $toolData['description'],
            'url' => url("/conversions/{$category}/{$tool}"),
            'isPartOf' => [
                '@id' => url('/') . '#software'
            ],
            'creator' => [
                '@id' => 'https://robertdavidorr.com/#person'
            ],
            'offers' => [
                '@type' => 'Offer',
                'price' => '0',
                'priceCurrency' => 'USD',
                'availability' => 'https://schema.org/InStock'
            ],
            'browserRequirements' => 'Requires JavaScript',
            'applicationCategory' => 'Text Processing',
            'inLanguage' => 'en',
            'potentialAction' => [
                '@type' => 'UseAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => url("/conversions/{$category}/{$tool}"),
                    'actionPlatform' => [
                        'http://schema.org/DesktopWebPlatform',
                        'http://schema.org/MobileWebPlatform'
                    ]
                ],
                'object' => [
                    '@type' => 'Text',
                    'name' => 'Input Text'
                ],
                'result' => [
                    '@type' => 'Text',
                    'name' => $toolData['name'] . ' Output'
                ]
            ]
        ];
    }

    /**
     * Generate FAQPage schema
     */
    public function generateFAQSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            '@id' => url('/faq') . '#faqpage',
            'name' => 'Case Changer Pro FAQ',
            'description' => 'Frequently asked questions about Case Changer Pro text transformation tools',
            'mainEntity' => [
                [
                    '@type' => 'Question',
                    'name' => 'Is Case Changer Pro free to use?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Yes, Case Changer Pro is completely free to use. All 86+ text transformation tools are available without registration or payment.'
                    ]
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Does Case Changer Pro store my text data?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'No, Case Changer Pro processes all text transformations locally in your browser. We don\'t store, transmit, or log any text you convert.'
                    ]
                ],
                [
                    '@type' => 'Question',
                    'name' => 'What types of text transformations are available?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Case Changer Pro offers 86+ transformation tools across 10 categories including case conversions, developer formats, journalistic styles, academic formats, creative formats, business formats, social media formats, technical documentation, international formats, and utility transformations.'
                    ]
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Can I use Case Changer Pro on mobile devices?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Yes, Case Changer Pro is fully responsive and works on all modern mobile devices and tablets with a web browser.'
                    ]
                ],
                [
                    '@type' => 'Question',
                    'name' => 'How do I use Case Changer Pro?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Simply select your desired conversion tool from our 10 categories, paste or type your text in the input field, and the conversion happens instantly. Click the copy button to copy the converted text to your clipboard.'
                    ]
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Does Case Changer Pro preserve special formatting?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Yes, Case Changer Pro intelligently preserves URLs, email addresses, and special formatting while converting your text. This ensures your links and contact information remain functional.'
                    ]
                ],
                [
                    '@type' => 'Question',
                    'name' => 'What browsers are supported?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Case Changer Pro works on all modern browsers including Chrome, Firefox, Safari, Edge, and Opera. JavaScript must be enabled for the tools to function.'
                    ]
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Can I process large amounts of text?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Yes, Case Changer Pro can handle large text inputs efficiently. The tools are optimized for performance and can process thousands of words instantly.'
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
            '@id' => url('/') . '#navigation',
            'name' => 'Main Navigation',
            'hasPart' => [
                [
                    '@type' => 'SiteNavigationElement',
                    'name' => 'Home',
                    'url' => url('/'),
                    'position' => 1
                ],
                [
                    '@type' => 'SiteNavigationElement',
                    'name' => 'All Tools',
                    'url' => url('/conversions'),
                    'position' => 2
                ],
                [
                    '@type' => 'SiteNavigationElement',
                    'name' => 'Categories',
                    'url' => url('/conversions'),
                    'position' => 3
                ],
                [
                    '@type' => 'SiteNavigationElement',
                    'name' => 'FAQ',
                    'url' => url('/faq'),
                    'position' => 4
                ],
                [
                    '@type' => 'SiteNavigationElement',
                    'name' => 'About',
                    'url' => url('/about'),
                    'position' => 5
                ]
            ]
        ];
    }

    /**
     * Generate complete homepage schema graph
     */
    public function generateHomepageSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                $this->generateWebSiteSchema(),
                $this->generatePersonSchema(),
                $this->generateSoftwareApplicationSchema(),
                $this->generateOrganizationSchema(),
                $this->generateNavigationSchema(),
                $this->generateFAQSchema()
            ]
        ];
    }

    /**
     * Generate schema for category page
     */
    public function generateCategoryPageSchema(string $category, array $categoryData): array
    {
        $breadcrumbs = $this->generateBreadcrumbSchema([
            ['name' => 'Tools', 'url' => url('/conversions')],
            ['name' => $categoryData['title']]
        ]);

        $collectionPage = $this->generateCollectionPageSchema($category, $categoryData);

        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                $collectionPage,
                $breadcrumbs
            ]
        ];
    }

    /**
     * Generate schema for tool page
     */
    public function generateToolPageSchema(string $category, string $tool, array $toolData, array $categoryData): array
    {
        $breadcrumbs = $this->generateBreadcrumbSchema([
            ['name' => 'Tools', 'url' => url('/conversions')],
            ['name' => $categoryData['title'], 'url' => url("/conversions/{$category}")],
            ['name' => $toolData['name']]
        ]);

        $toolSchema = $this->generateToolSchema($category, $tool, $toolData, $categoryData);

        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                $toolSchema,
                $breadcrumbs,
                $this->generatePersonSchema()
            ]
        ];
    }
}