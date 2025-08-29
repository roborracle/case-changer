<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductionDefaultsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed default categories
        DB::table('categories')->insert([
            ['name' => 'Case Conversion', 'slug' => 'case-conversions'],
            ['name' => 'Developer Formats', 'slug' => 'developer-formats'],
            ['name' => 'Journalistic Styles', 'slug' => 'journalistic-styles'],
            ['name' => 'Academic Styles', 'slug' => 'academic-styles'],
            ['name' => 'Creative Formats', 'slug' => 'creative-formats'],
            ['name' => 'Business Formats', 'slug' => 'business-formats'],
            ['name' => 'Social Media Formats', 'slug' => 'social-media-formats'],
            ['name' => 'Technical Documentation', 'slug' => 'technical-documentation'],
            ['name' => 'International Formats', 'slug' => 'international-formats'],
            ['name' => 'Utility Transformations', 'slug' => 'utility-transformations'],
            ['name' => 'Text Effects', 'slug' => 'text-effects'],
            ['name' => 'Random Generators', 'slug' => 'generators'],
            ['name' => 'Code & Data Tools', 'slug' => 'code-data-tools'],
            ['name' => 'Image Converters', 'slug' => 'image-converters'],
            ['name' => 'Text Analysis', 'slug' => 'text-analysis'],
            ['name' => 'Text Cleanup', 'slug' => 'text-cleanup'],
            ['name' => 'Social Media Generators', 'slug' => 'social-media-generators'],
            ['name' => 'Miscellaneous Tools', 'slug' => 'miscellaneous-tools'],
        ]);
    }
}
