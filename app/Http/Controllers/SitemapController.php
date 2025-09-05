<?php

namespace App\Http\Controllers;

use App\Services\ToolService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
    protected ToolService $toolService;
    
    public function __construct(ToolService $toolService)
    {
        $this->toolService = $toolService;
    }
    
    public function index()
    {
        $categories = $this->toolService->getCategoriesWithTools();
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        // Homepage
        $xml .= $this->generateUrl(url('/'), '1.0', 'daily');
        
        // All tools page
        $xml .= $this->generateUrl(route('conversions.index'), '0.9', 'weekly');
        
        // Category pages
        foreach ($categories as $categorySlug => $category) {
            $xml .= $this->generateUrl(
                route('conversions.category', $categorySlug),
                '0.8',
                'weekly'
            );
            
            // Individual tool pages
            foreach ($category['tools'] as $toolSlug => $tool) {
                $xml .= $this->generateUrl(
                    route('conversions.tool', [$categorySlug, $toolSlug]),
                    '0.7',
                    'monthly'
                );
            }
        }
        
        // Static pages
        $staticPages = ['about', 'contact', 'privacy', 'terms'];
        foreach ($staticPages as $page) {
            if (route_exists("pages.{$page}")) {
                $xml .= $this->generateUrl(route("pages.{$page}"), '0.5', 'monthly');
            }
        }
        
        $xml .= '</urlset>';
        
        return Response::make($xml, 200)->header('Content-Type', 'application/xml');
    }
    
    protected function generateUrl($loc, $priority = '0.5', $changefreq = 'weekly')
    {
        $lastmod = date('Y-m-d');
        return "<url>
            <loc>{$loc}</loc>
            <lastmod>{$lastmod}</lastmod>
            <changefreq>{$changefreq}</changefreq>
            <priority>{$priority}</priority>
        </url>";
    }
}

// Helper function
if (!function_exists('route_exists')) {
    function route_exists($name)
    {
        return app('router')->has($name);
    }
}