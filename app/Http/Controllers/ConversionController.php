<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SchemaService;

class ConversionController extends Controller
{
    protected SchemaService $schemaService;

    public function __construct(SchemaService $schemaService)
    {
        $this->schemaService = $schemaService;
    }

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
        'text-effects' => [
            'title' => 'Text Effects',
            'description' => 'Visual text effects and stylized formatting',
            'icon' => 'sparkles',
            'tools' => [
                'bold-text' => ['name' => 'Bold Text', 'description' => '𝗕𝗼𝗹𝗱 𝘁𝗲𝘅𝘁 𝗴𝗲𝗻𝗲𝗿𝗮𝘁𝗼𝗿'],
                'italic-text' => ['name' => 'Italic Text', 'description' => '𝘐𝘵𝘢𝘭𝘪𝘤 𝘵𝘦𝘹𝘵 𝘤𝘰𝘯𝘷𝘦𝘳𝘵𝘦𝘳'],
                'strikethrough-text' => ['name' => 'Strikethrough Text', 'description' => 'S̶t̶r̶i̶k̶e̶t̶h̶r̶o̶u̶g̶h̶ ̶t̶e̶x̶t̶'],
                'underline-text' => ['name' => 'Underline Text', 'description' => 'U̲n̲d̲e̲r̲l̲i̲n̲e̲ ̲t̲e̲x̲t̲'],
                'superscript' => ['name' => 'Superscript', 'description' => 'ˢᵘᵖᵉʳˢᶜʳⁱᵖᵗ text'],
                'subscript' => ['name' => 'Subscript', 'description' => 'ₛᵤbₛcᵣᵢₚₜ text'],
                'wide-text' => ['name' => 'Wide Text', 'description' => 'Ｗｉｄｅ　ｔｅｘｔ　ｇｅｎｅｒａｔｏｒ'],
                'upside-down' => ['name' => 'Upside Down', 'description' => 'uʍop ǝpᴉsdn text'],
                'mirror-text' => ['name' => 'Mirror Text', 'description' => 'txet rorriM'],
                'zalgo-text' => ['name' => 'Zalgo Text', 'description' => 'Z̴̢̪͚̱̦̀a̵̡̺̓l̸̥̇g̷͉̈́o̶̝̐ ̴̱̇t̵̯͌ë̵̱x̴̱̾t̷̩̀'],
                'cursed-text' => ['name' => 'Cursed Text', 'description' => 'C̷u̸r̶s̸e̷d̶ ̴t̸e̷x̴t̶'],
                'invisible-text' => ['name' => 'Invisible Text', 'description' => 'Hidden zero-width text'],
            ]
        ],
        'generators' => [
            'title' => 'Random Generators',
            'description' => 'Generate random data, passwords, IDs, and more',
            'icon' => 'dice',
            'tools' => [
                'password-generator' => ['name' => 'Password Generator', 'description' => 'Generate strong random passwords'],
                'uuid-generator' => ['name' => 'UUID Generator', 'description' => 'Generate unique identifiers (UUID v4)'],
                'random-number' => ['name' => 'Random Number', 'description' => 'Generate random numbers'],
                'random-letter' => ['name' => 'Random Letter', 'description' => 'Generate random letters'],
                'random-date' => ['name' => 'Random Date', 'description' => 'Generate random dates'],
                'random-month' => ['name' => 'Random Month', 'description' => 'Generate random months'],
                'random-ip' => ['name' => 'Random IP', 'description' => 'Generate random IP addresses'],
                'random-choice' => ['name' => 'Random Choice', 'description' => 'Pick random items from a list'],
                'lorem-ipsum' => ['name' => 'Lorem Ipsum', 'description' => 'Generate placeholder text'],
                'username-generator' => ['name' => 'Username Generator', 'description' => 'Generate random usernames'],
                'email-generator' => ['name' => 'Email Generator', 'description' => 'Generate random email addresses'],
                'hex-color' => ['name' => 'Hex Color', 'description' => 'Generate random hex colors'],
                'phone-number' => ['name' => 'Phone Number', 'description' => 'Generate random phone numbers'],
            ]
        ],
        'code-data-tools' => [
            'title' => 'Code & Data Tools',
            'description' => 'Formatters, converters, encoders for developers',
            'icon' => 'code',
            'tools' => [
                'binary-translator' => ['name' => 'Binary Translator', 'description' => 'Convert text to/from binary code'],
                'hex-converter' => ['name' => 'Hex Converter', 'description' => 'Convert text to/from hexadecimal'],
                'morse-code' => ['name' => 'Morse Code Translator', 'description' => 'Convert text to/from Morse code'],
                'caesar-cipher' => ['name' => 'Caesar Cipher', 'description' => 'Encrypt/decrypt with Caesar cipher'],
                'md5-hash' => ['name' => 'MD5 Hash Generator', 'description' => 'Generate MD5 hash from text'],
                'sha256-hash' => ['name' => 'SHA256 Hash Generator', 'description' => 'Generate SHA256 hash from text'],
                'json-formatter' => ['name' => 'JSON Formatter', 'description' => 'Format and minify JSON data'],
                'csv-to-json' => ['name' => 'CSV to JSON Converter', 'description' => 'Convert CSV data to JSON format'],
                'css-formatter' => ['name' => 'CSS Formatter', 'description' => 'Format and minify CSS code'],
                'html-formatter' => ['name' => 'HTML Formatter', 'description' => 'Format and minify HTML code'],
                'javascript-formatter' => ['name' => 'JavaScript Formatter', 'description' => 'Format JavaScript code'],
                'xml-formatter' => ['name' => 'XML Formatter', 'description' => 'Format XML documents'],
                'yaml-formatter' => ['name' => 'YAML Formatter', 'description' => 'Format YAML configuration files'],
                'utf8-converter' => ['name' => 'UTF-8 Converter', 'description' => 'Convert text to UTF-8 encoding'],
                'utm-builder' => ['name' => 'UTM Builder', 'description' => 'Build UTM tracking URLs'],
                'slugify-generator' => ['name' => 'Slug Generator', 'description' => 'Create URL-friendly slugs']
            ]
        ],
        'image-converters' => [
            'title' => 'Image Converters',
            'description' => 'Image format conversion tools',
            'icon' => 'image',
            'tools' => [
                'ascii-art' => ['name' => 'ASCII Art Generator', 'description' => 'Convert text to ASCII art'],
                'image-to-text' => ['name' => 'Image to Text', 'description' => 'Extract text from images (OCR)'],
                'jpg-to-png' => ['name' => 'JPG to PNG', 'description' => 'Convert JPG images to PNG format'],
                'png-to-jpg' => ['name' => 'PNG to JPG', 'description' => 'Convert PNG images to JPG format'],
                'jpg-to-webp' => ['name' => 'JPG to WebP', 'description' => 'Convert JPG images to WebP format'],
                'png-to-webp' => ['name' => 'PNG to WebP', 'description' => 'Convert PNG images to WebP format'],
                'webp-to-jpg' => ['name' => 'WebP to JPG', 'description' => 'Convert WebP images to JPG format'],
                'webp-to-png' => ['name' => 'WebP to PNG', 'description' => 'Convert WebP images to PNG format'],
                'svg-to-png' => ['name' => 'SVG to PNG', 'description' => 'Convert SVG images to PNG format']
            ]
        ],
        'text-analysis' => [
            'title' => 'Text Analysis',
            'description' => 'Analyze and process text content',
            'icon' => 'chart',
            'tools' => [
                'word-counter' => ['name' => 'Word Counter', 'description' => 'Count words, characters, and sentences'],
                'sentence-counter' => ['name' => 'Sentence Counter', 'description' => 'Count sentences in text'],
                'word-frequency' => ['name' => 'Word Frequency', 'description' => 'Analyze word frequency and usage'],
                'duplicate-finder' => ['name' => 'Duplicate Finder', 'description' => 'Find duplicate words and lines'],
                'duplicate-remover' => ['name' => 'Duplicate Remover', 'description' => 'Remove duplicate lines'],
                'sort-words' => ['name' => 'Sort Words', 'description' => 'Sort words alphabetically'],
                'text-replacer' => ['name' => 'Text Replacer', 'description' => 'Find and replace text patterns'],
                'line-break-remover' => ['name' => 'Line Break Remover', 'description' => 'Remove line breaks from text']
            ]
        ],
        'text-cleanup' => [
            'title' => 'Text Cleanup',
            'description' => 'Clean and format text content',
            'icon' => 'eraser',
            'tools' => [
                'plain-text-converter' => ['name' => 'Plain Text Converter', 'description' => 'Convert to plain text format'],
                'remove-formatting' => ['name' => 'Remove Formatting', 'description' => 'Strip all text formatting'],
                'remove-letters' => ['name' => 'Remove Letters', 'description' => 'Remove specific letters/characters'],
                'remove-underscores' => ['name' => 'Remove Underscores', 'description' => 'Remove underscore characters'],
                'whitespace-remover' => ['name' => 'Whitespace Remover', 'description' => 'Remove extra whitespace'],
                'repeat-text' => ['name' => 'Repeat Text', 'description' => 'Repeat text multiple times'],
                'phonetic-spelling' => ['name' => 'Phonetic Spelling', 'description' => 'Convert to phonetic spelling'],
                'pig-latin' => ['name' => 'Pig Latin Translator', 'description' => 'Convert text to Pig Latin']
            ]
        ],
        'social-media-generators' => [
            'title' => 'Social Media Generators',
            'description' => 'Generate fonts for social media platforms',
            'icon' => 'hashtag',
            'tools' => [
                'discord-font' => ['name' => 'Discord Font Generator', 'description' => 'Generate Discord-compatible fonts'],
                'facebook-font' => ['name' => 'Facebook Font Generator', 'description' => 'Generate Facebook-compatible fonts'],
                'instagram-font' => ['name' => 'Instagram Font Generator', 'description' => 'Generate Instagram-compatible fonts'],
                'twitter-font' => ['name' => 'Twitter Font Generator', 'description' => 'Generate Twitter/X-compatible fonts'],
                'big-text' => ['name' => 'Big Text Converter', 'description' => 'Generate large text for social media'],
                'slash-text' => ['name' => 'Slash Text Generator', 'description' => 'Add slashes through text'],
                'stacked-text' => ['name' => 'Stacked Text Generator', 'description' => 'Create vertically stacked text'],
                'wingdings' => ['name' => 'Wingdings Converter', 'description' => 'Convert text to Wingdings symbols']
            ]
        ],
        'miscellaneous-tools' => [
            'title' => 'Miscellaneous Tools',
            'description' => 'Various utility tools and converters',
            'icon' => 'wrench',
            'tools' => [
                'nato-phonetic' => ['name' => 'NATO Phonetic Alphabet', 'description' => 'Convert to NATO phonetic alphabet'],
                'roman-numerals' => ['name' => 'Roman Numerals', 'description' => 'Convert numbers to Roman numerals'],
                'word-cloud' => ['name' => 'Word Cloud Generator', 'description' => 'Generate word cloud from text'],
                'notepad' => ['name' => 'Online Notepad', 'description' => 'Simple online text editor'],
                'regex-tester' => ['name' => 'Regex Tester', 'description' => 'Test regular expressions'],
                'number-sorter' => ['name' => 'Number Sorter', 'description' => 'Sort numbers in ascending/descending order'],
                'unicode-converter' => ['name' => 'Unicode Converter', 'description' => 'Convert text to Unicode format']
            ]
        ]
    ];

    /**
     * Display the main categories index
     */
    public function index()
    {
        $breadcrumbs = $this->schemaService->generateBreadcrumbSchema([
            ['name' => 'All Tools']
        ]);

        return view('conversions.index', [
            'categories' => $this->categories,
            'schemaData' => $breadcrumbs
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

        $schemaData = $this->schemaService->getCategorySchemas($category, $this->categories[$category]);

        return view('conversions.category', [
            'category' => $category,
            'categoryData' => $this->categories[$category],
            'allCategories' => $this->categories,
            'schemaData' => $schemaData
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

        $schemaData = $this->schemaService->getToolSchemas(
            $category,
            $tool,
            $this->categories[$category],
            $this->categories[$category]['tools'][$tool]
        );

        return view('conversions.tool', [
            'category' => $category,
            'tool' => $tool,
            'categoryData' => $this->categories[$category],
            'toolData' => $this->categories[$category]['tools'][$tool],
            'allCategories' => $this->categories,
            'schemaData' => $schemaData
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