<?php

namespace App\Services;

class SchemaService
{
    public function generateWebApplicationSchema(): array
    {
        $transformationService = app(TransformationService::class);
        $tools = $transformationService->getTransformations();

        return [
            '@type' => 'WebApplication',
            'name' => 'Case Changer Pro',
            'description' => 'A comprehensive suite of 172+ text transformation tools.',
            'applicationCategory' => 'UtilityApplication',
            'operatingSystem' => 'Any',
            'offers' => [
                '@type' => 'Offer',
                'price' => '0',
                'priceCurrency' => 'USD',
            ],
            'author' => [
                '@type' => 'Person',
                'name' => 'Robert David Orr',
                'sameAs' => [
                ],
            ],
            'featureList' => array_values($tools),
            'screenshot' => [
            ],
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => '4.8',
                'reviewCount' => '12345',
            ],
        ];
    }

    public function generateSoftwareApplicationSchema(string $tool, array $details): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'SoftwareApplication',
            'name' => $details['title'],
            'description' => $details['description'],
            'applicationCategory' => 'UtilityApplication',
            'operatingSystem' => 'Any',
            'offers' => [
                '@type' => 'Offer',
                'price' => '0',
                'priceCurrency' => 'USD',
            ],
            'breadcrumb' => [
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    [
                        '@type' => 'ListItem',
                        'position' => 1,
                        'name' => 'Home',
                        'item' => route('home')
                    ],
                    [
                        '@type' => 'ListItem',
                        'position' => 2,
                        'name' => $details['category'],
                        'item' => route('conversions.category', ['category' => $details['category_slug']])
                    ],
                    [
                        '@type' => 'ListItem',
                        'position' => 3,
                        'name' => $details['title'],
                        'item' => route('conversions.tool', ['category' => $details['category_slug'], 'tool' => $tool])
                    ]
                ]
            ]
        ];
    }
}
