<?php

namespace App\Services;

class ToolService
{
    protected $categories;
    protected $tools;
    
    public function __construct()
    {
        $this->categories = config('categories.categories');
        $this->tools = config('tools');
    }
    
    /**
     * Get categories with their tools included
     */
    public function getCategoriesWithTools()
    {
        $categoriesWithTools = [];
        
        foreach ($this->categories as $categorySlug => $category) {
            $tools = $this->tools[$categorySlug] ?? [];
            $toolsWithSlugs = [];
            foreach ($tools as $toolSlug => $tool) {
                $tool['slug'] = $toolSlug;
                $toolsWithSlugs[$toolSlug] = $tool;
            }
            $category['tools'] = $toolsWithSlugs;
            $category['tool_count'] = count($toolsWithSlugs);
            $categoriesWithTools[$categorySlug] = $category;
        }
        
        return $categoriesWithTools;
    }
    
    /**
     * Get a single category with tools
     */
    public function getCategoryWithTools($categorySlug)
    {
        if (!isset($this->categories[$categorySlug])) {
            return null;
        }
        
        $category = $this->categories[$categorySlug];
        $tools = $this->tools[$categorySlug] ?? [];
        $toolsWithSlugs = [];
        foreach ($tools as $toolSlug => $tool) {
            $tool['slug'] = $toolSlug;
            $toolsWithSlugs[$toolSlug] = $tool;
        }
        $category['tools'] = $toolsWithSlugs;
        $category['tool_count'] = count($toolsWithSlugs);
        
        return $category;
    }
    
    /**
     * Get a specific tool
     */
    public function getTool($categorySlug, $toolSlug)
    {
        if (!isset($this->tools[$categorySlug][$toolSlug])) {
            return null;
        }
        
        $tool = $this->tools[$categorySlug][$toolSlug];
        $tool['slug'] = $toolSlug;
        $tool['category'] = $categorySlug;
        $tool['category_name'] = $this->categories[$categorySlug]['name'] ?? '';
        
        return $tool;
    }
    
    /**
     * Get all tools flat list
     */
    public function getAllTools()
    {
        $allTools = [];
        
        foreach ($this->tools as $categorySlug => $categoryTools) {
            foreach ($categoryTools as $toolSlug => $tool) {
                $tool['slug'] = $toolSlug;
                $tool['category'] = $categorySlug;
                $tool['category_name'] = $this->categories[$categorySlug]['name'] ?? '';
                $allTools[$toolSlug] = $tool;
            }
        }
        
        return $allTools;
    }
    
    /**
     * Get tool count
     */
    public function getTotalToolCount()
    {
        $count = 0;
        foreach ($this->tools as $categoryTools) {
            $count += count($categoryTools);
        }
        return $count;
    }
}