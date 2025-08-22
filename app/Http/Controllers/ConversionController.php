<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConversionController extends Controller
{
    /**
     * Category structure with all conversion types
     */
    private array $categories = [
        'case-conversions' => [
            'title' => 'Case Conversions',
            'description' => 'Traditional text case transformations for any content',
            'icon' => 'text',
            'tools' => [
                'uppercase' => ['name' => 'UPPERCASE', 'description' => 'Convert text to ALL CAPITAL LETTERS'],
                'lowercase' => ['name' => 'lowercase', 'description' => 'Convert text to all lowercase letters'],
                'title-case' => ['name' => 'Title Case', 'description' => 'Capitalize The First Letter Of Each Word'],
                'sentence-case' => ['name' => 'Sentence case', 'description' => 'Capitalize only the first letter of sentences'],
                'capitalize-words' => ['name' => 'Capitalize Words', 'description' => 'Capitalize Every Word In Text'],
                'alternating-case' => ['name' => 'aLtErNaTiNg CaSe', 'description' => 'AlTeRnAtE bEtWeEn UpPeR aNd LoWeR'],
                'inverse-case' => ['name' => 'iNVERSE cASE', 'description' => 'iNVERT THE NORMAL CAPITALIZATION'],
            ]
        ],
        'developer-formats' => [
            'title' => 'Developer Formats',
            'description' => 'Programming and development text formats',
            'icon' => 'code',
            'tools' => [
                'camel-case' => ['name' => 'camelCase', 'description' => 'camelCaseForVariableNames'],
                'pascal-case' => ['name' => 'PascalCase', 'description' => 'PascalCaseForClassNames'],
                'snake-case' => ['name' => 'snake_case', 'description' => 'snake_case_for_variables'],
                'constant-case' => ['name' => 'CONSTANT_CASE', 'description' => 'CONSTANT_CASE_FOR_CONSTANTS'],
                'kebab-case' => ['name' => 'kebab-case', 'description' => 'kebab-case-for-urls'],
                'dot-case' => ['name' => 'dot.case', 'description' => 'dot.case.for.namespaces'],
                'path-case' => ['name' => 'path/case', 'description' => 'path/case/for/routes'],
                'namespace-case' => ['name' => 'namespace\\case', 'description' => 'namespace\\case\\for\\php'],
                'ada-case' => ['name' => 'Ada_Case', 'description' => 'Ada_Case_For_Ada_Lang'],
                'cobol-case' => ['name' => 'COBOL-CASE', 'description' => 'COBOL-CASE-FOR-LEGACY'],
                'train-case' => ['name' => 'Train-Case', 'description' => 'Train-Case-For-Titles'],
                'http-header-case' => ['name' => 'Http-Header-Case', 'description' => 'Http-Header-Case-Format'],
            ]
        ],
        'journalistic-styles' => [
            'title' => 'Journalistic Styles',
            'description' => 'Professional journalism and media style guides',
            'icon' => 'newspaper',
            'tools' => [
                'ap-style' => ['name' => 'AP Style', 'description' => 'Associated Press style guide for news writing'],
                'nyt-style' => ['name' => 'New York Times Style', 'description' => 'The New York Times Manual of Style'],
                'chicago-style' => ['name' => 'Chicago Style', 'description' => 'Chicago Manual of Style for publications'],
                'guardian-style' => ['name' => 'Guardian Style', 'description' => 'The Guardian and Observer style guide'],
                'bbc-style' => ['name' => 'BBC Style', 'description' => 'BBC News style guide'],
                'reuters-style' => ['name' => 'Reuters Style', 'description' => 'Reuters Handbook of Journalism'],
                'economist-style' => ['name' => 'Economist Style', 'description' => 'The Economist Style Guide'],
                'wsj-style' => ['name' => 'WSJ Style', 'description' => 'Wall Street Journal style guide'],
            ]
        ],
        'academic-styles' => [
            'title' => 'Academic Styles',
            'description' => 'Academic and scholarly writing formats',
            'icon' => 'academic',
            'tools' => [
                'apa-style' => ['name' => 'APA Style', 'description' => 'American Psychological Association style'],
                'mla-style' => ['name' => 'MLA Style', 'description' => 'Modern Language Association style'],
                'chicago-author-date' => ['name' => 'Chicago Author-Date', 'description' => 'Chicago Manual author-date system'],
                'chicago-notes' => ['name' => 'Chicago Notes', 'description' => 'Chicago Manual notes and bibliography'],
                'harvard-style' => ['name' => 'Harvard Style', 'description' => 'Harvard referencing system'],
                'vancouver-style' => ['name' => 'Vancouver Style', 'description' => 'Vancouver referencing system'],
                'ieee-style' => ['name' => 'IEEE Style', 'description' => 'Institute of Electrical and Electronics Engineers'],
                'ama-style' => ['name' => 'AMA Style', 'description' => 'American Medical Association style'],
                'bluebook-style' => ['name' => 'Bluebook Style', 'description' => 'Legal citation format'],
            ]
        ],
        'creative-formats' => [
            'title' => 'Creative Formats',
            'description' => 'Fun and creative text transformations',
            'icon' => 'sparkles',
            'tools' => [
                'reverse' => ['name' => 'Reverse', 'description' => 'esreveR ruoy txet'],
                'aesthetic' => ['name' => 'Aesthetic', 'description' => 'a e s t h e t i c  s p a c i n g'],
                'sarcasm' => ['name' => 'Sarcasm Case', 'description' => 'sArCaSm CaSe FoR mOcKiNg'],
                'smallcaps' => ['name' => 'Small Caps', 'description' => 'sᴍᴀʟʟ ᴄᴀᴘs ғᴏʀᴍᴀᴛ'],
                'bubble' => ['name' => 'Bubble Text', 'description' => 'ⓑⓤⓑⓑⓛⓔ ⓣⓔⓧⓣ'],
                'square' => ['name' => 'Square Text', 'description' => '🅂🅀🅄🄰🅁🄴 🅃🄴🅇🅃'],
                'script' => ['name' => 'Script', 'description' => '𝓈𝒸𝓇𝒾𝓅𝓉 𝓉𝑒𝓍𝓉'],
                'double-struck' => ['name' => 'Double Struck', 'description' => '𝕕𝕠𝕦𝕓𝕝𝕖 𝕤𝕥𝕣𝕦𝕔𝕜'],
                'bold' => ['name' => 'Bold', 'description' => '𝐛𝐨𝐥𝐝 𝐭𝐞𝐱𝐭'],
                'italic' => ['name' => 'Italic', 'description' => '𝘪𝘵𝘢𝘭𝘪𝘤 𝘵𝘦𝘹𝘵'],
                'emoji-case' => ['name' => 'Emoji Case', 'description' => '🔤 Emoji enhanced text'],
            ]
        ],
        'business-formats' => [
            'title' => 'Business Formats',
            'description' => 'Professional business communication styles',
            'icon' => 'briefcase',
            'tools' => [
                'email-style' => ['name' => 'Email Style', 'description' => 'Professional email formatting'],
                'legal-style' => ['name' => 'Legal Style', 'description' => 'LEGAL DOCUMENT FORMATTING'],
                'marketing-headline' => ['name' => 'Marketing Headline', 'description' => 'Attention-Grabbing Headlines'],
                'press-release' => ['name' => 'Press Release', 'description' => 'Press release formatting'],
                'memo-style' => ['name' => 'Memo Style', 'description' => 'Business memorandum format'],
                'report-style' => ['name' => 'Report Style', 'description' => 'Formal report formatting'],
                'proposal-style' => ['name' => 'Proposal Style', 'description' => 'Business proposal format'],
                'invoice-style' => ['name' => 'Invoice Style', 'description' => 'Invoice and billing format'],
            ]
        ],
        'social-media-formats' => [
            'title' => 'Social Media Formats',
            'description' => 'Optimized formats for social media platforms',
            'icon' => 'share',
            'tools' => [
                'twitter-style' => ['name' => 'Twitter/X Style', 'description' => 'Optimized for Twitter/X posts'],
                'instagram-style' => ['name' => 'Instagram Style', 'description' => 'Instagram caption formatting'],
                'linkedin-style' => ['name' => 'LinkedIn Style', 'description' => 'Professional LinkedIn formatting'],
                'facebook-style' => ['name' => 'Facebook Style', 'description' => 'Facebook post optimization'],
                'youtube-title' => ['name' => 'YouTube Title', 'description' => 'YouTube video title optimization'],
                'tiktok-style' => ['name' => 'TikTok Style', 'description' => 'TikTok caption and hashtag format'],
                'hashtag-style' => ['name' => 'Hashtag Style', 'description' => '#HashtagGeneration'],
                'mention-style' => ['name' => 'Mention Style', 'description' => '@mention formatting'],
            ]
        ],
        'technical-documentation' => [
            'title' => 'Technical Documentation',
            'description' => 'Technical writing and documentation formats',
            'icon' => 'document',
            'tools' => [
                'api-docs' => ['name' => 'API Documentation', 'description' => 'REST API documentation format'],
                'readme-style' => ['name' => 'README Style', 'description' => 'GitHub README formatting'],
                'changelog-style' => ['name' => 'Changelog Style', 'description' => 'Software changelog format'],
                'user-manual' => ['name' => 'User Manual', 'description' => 'User guide formatting'],
                'technical-spec' => ['name' => 'Technical Spec', 'description' => 'Technical specification format'],
                'code-comments' => ['name' => 'Code Comments', 'description' => 'Code documentation comments'],
                'wiki-style' => ['name' => 'Wiki Style', 'description' => 'Wiki article formatting'],
                'markdown-style' => ['name' => 'Markdown Style', 'description' => 'Markdown document format'],
            ]
        ],
        'international-formats' => [
            'title' => 'International Formats',
            'description' => 'Language and region-specific formatting',
            'icon' => 'globe',
            'tools' => [
                'british-english' => ['name' => 'British English', 'description' => 'UK spelling and formatting'],
                'american-english' => ['name' => 'American English', 'description' => 'US spelling and formatting'],
                'canadian-english' => ['name' => 'Canadian English', 'description' => 'Canadian spelling conventions'],
                'australian-english' => ['name' => 'Australian English', 'description' => 'Australian spelling conventions'],
                'eu-format' => ['name' => 'EU Format', 'description' => 'European Union standards'],
                'iso-format' => ['name' => 'ISO Format', 'description' => 'International standards format'],
                'unicode-normalize' => ['name' => 'Unicode Normalize', 'description' => 'Unicode normalization'],
                'ascii-convert' => ['name' => 'ASCII Convert', 'description' => 'Convert to ASCII characters'],
            ]
        ],
        'utility-transformations' => [
            'title' => 'Utility Transformations',
            'description' => 'Practical text manipulation utilities',
            'icon' => 'tool',
            'tools' => [
                'remove-spaces' => ['name' => 'Remove Spaces', 'description' => 'RemoveAllSpaces'],
                'remove-extra-spaces' => ['name' => 'Remove Extra Spaces', 'description' => 'Remove  Extra  Spaces'],
                'add-dashes' => ['name' => 'Add Dashes', 'description' => 'Add-Dashes-Between-Words'],
                'add-underscores' => ['name' => 'Add Underscores', 'description' => 'Add_Underscores_Between_Words'],
                'add-periods' => ['name' => 'Add Periods', 'description' => 'Add.Periods.Between.Words'],
                'remove-punctuation' => ['name' => 'Remove Punctuation', 'description' => 'Remove all punctuation marks'],
                'extract-letters' => ['name' => 'Extract Letters', 'description' => 'Extract only letters'],
                'extract-numbers' => ['name' => 'Extract Numbers', 'description' => 'Extract only numbers'],
                'remove-duplicates' => ['name' => 'Remove Duplicates', 'description' => 'Remove duplicate words'],
                'sort-words' => ['name' => 'Sort Words', 'description' => 'Sort words alphabetically'],
                'shuffle-words' => ['name' => 'Shuffle Words', 'description' => 'Randomly shuffle words'],
                'word-frequency' => ['name' => 'Word Frequency', 'description' => 'Count word occurrences'],
            ]
        ],
    ];

    /**
     * Display the main categories index
     */
    public function index()
    {
        return view('conversions.index', [
            'categories' => $this->categories
        ]);
    }

    /**
     * Display a specific category page
     */
    public function category($category)
    {
        if (!isset($this->categories[$category])) {
            abort(404);
        }

        return view('conversions.category', [
            'category' => $category,
            'categoryData' => $this->categories[$category],
            'allCategories' => $this->categories
        ]);
    }

    /**
     * Display a specific conversion tool page
     */
    public function tool($category, $tool)
    {
        if (!isset($this->categories[$category]) || !isset($this->categories[$category]['tools'][$tool])) {
            abort(404);
        }

        return view('conversions.tool', [
            'category' => $category,
            'tool' => $tool,
            'categoryData' => $this->categories[$category],
            'toolData' => $this->categories[$category]['tools'][$tool],
            'allCategories' => $this->categories
        ]);
    }

    /**
     * Get category data for API
     */
    public function getCategoryData($category)
    {
        if (!isset($this->categories[$category])) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        return response()->json($this->categories[$category]);
    }

    /**
     * Get all categories for sitemap
     */
    public function getAllCategories()
    {
        return response()->json($this->categories);
    }
}