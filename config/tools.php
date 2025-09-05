<?php

/**
 * Tool Configuration
 * Complete mapping of all text transformation tools across 18 categories
 */

return [
    'case-conversions' => [
        'upper-case' => [
            'name' => 'Upper Case',
            'description' => 'Convert text to uppercase letters',
            'icon' => '🔤'
        ],
        'lower-case' => [
            'name' => 'Lower Case',
            'description' => 'Convert text to lowercase letters',
            'icon' => '🔡'
        ],
        'title-case' => [
            'name' => 'Title Case',
            'description' => 'Capitalize the first letter of each word',
            'icon' => '📝'
        ],
        'sentence-case' => [
            'name' => 'Sentence Case',
            'description' => 'Capitalize the first letter of each sentence',
            'icon' => '📄'
        ],
        'capitalize-words' => [
            'name' => 'Capitalize Words',
            'description' => 'Capitalize the first letter of every word',
            'icon' => '🔤'
        ],
        'alternating-case' => [
            'name' => 'Alternating Case',
            'description' => 'Alternate between uppercase and lowercase letters',
            'icon' => '🔀'
        ],
        'inverse-case' => [
            'name' => 'Inverse Case',
            'description' => 'Swap uppercase and lowercase letters',
            'icon' => '🔄'
        ]
    ],
    
    'developer-formats' => [
        'camel-case' => [
            'name' => 'Camel Case',
            'description' => 'Convert to camelCase format',
            'icon' => '🐪'
        ],
        'pascal-case' => [
            'name' => 'Pascal Case',
            'description' => 'Convert to PascalCase format',
            'icon' => '📦'
        ],
        'snake-case' => [
            'name' => 'Snake Case',
            'description' => 'Convert to snake_case format',
            'icon' => '🐍'
        ],
        'constant-case' => [
            'name' => 'Constant Case',
            'description' => 'Convert to CONSTANT_CASE format',
            'icon' => '📊'
        ],
        'kebab-case' => [
            'name' => 'Kebab Case',
            'description' => 'Convert to kebab-case format',
            'icon' => '🍢'
        ],
        'dot-case' => [
            'name' => 'Dot Case',
            'description' => 'Convert to dot.case format',
            'icon' => '⚫'
        ],
        'path-case' => [
            'name' => 'Path Case',
            'description' => 'Convert to path/case format',
            'icon' => '📁'
        ],
        'sql-case' => [
            'name' => 'SQL Case',
            'description' => 'Format for SQL queries',
            'icon' => '🗃️'
        ],
        'python-case' => [
            'name' => 'Python Case',
            'description' => 'Python naming convention',
            'icon' => '🐍'
        ],
        'java-case' => [
            'name' => 'Java Case',
            'description' => 'Java naming convention',
            'icon' => '☕'
        ],
        'php-case' => [
            'name' => 'PHP Case',
            'description' => 'PHP naming convention',
            'icon' => '🐘'
        ],
        'ruby-case' => [
            'name' => 'Ruby Case',
            'description' => 'Ruby naming convention',
            'icon' => '💎'
        ]
    ],
    
    'journalistic-styles' => [
        'ap-style' => [
            'name' => 'AP Style',
            'description' => 'Associated Press style guide',
            'icon' => '📰'
        ],
        'nyt-style' => [
            'name' => 'NY Times Style',
            'description' => 'New York Times style guide',
            'icon' => '🗞️'
        ],
        'chicago-style' => [
            'name' => 'Chicago Style',
            'description' => 'Chicago Manual of Style',
            'icon' => '📚'
        ],
        'guardian-style' => [
            'name' => 'Guardian Style',
            'description' => 'Guardian newspaper style',
            'icon' => '📰'
        ],
        'bbc-style' => [
            'name' => 'BBC Style',
            'description' => 'BBC News style guide',
            'icon' => '📺'
        ],
        'reuters-style' => [
            'name' => 'Reuters Style',
            'description' => 'Reuters news agency style',
            'icon' => '📡'
        ],
        'economist-style' => [
            'name' => 'Economist Style',
            'description' => 'The Economist style guide',
            'icon' => '📊'
        ],
        'wsj-style' => [
            'name' => 'WSJ Style',
            'description' => 'Wall Street Journal style',
            'icon' => '💼'
        ]
    ],
    
    'academic-styles' => [
        'apa-style' => [
            'name' => 'APA Style',
            'description' => 'American Psychological Association style',
            'icon' => '🎓'
        ],
        'mla-style' => [
            'name' => 'MLA Style',
            'description' => 'Modern Language Association style',
            'icon' => '📖'
        ],
        'chicago-author-date' => [
            'name' => 'Chicago Author-Date',
            'description' => 'Chicago author-date citation',
            'icon' => '📅'
        ],
        'chicago-notes' => [
            'name' => 'Chicago Notes',
            'description' => 'Chicago notes and bibliography',
            'icon' => '📝'
        ],
        'harvard-style' => [
            'name' => 'Harvard Style',
            'description' => 'Harvard referencing style',
            'icon' => '🏛️'
        ],
        'vancouver-style' => [
            'name' => 'Vancouver Style',
            'description' => 'Vancouver citation style',
            'icon' => '🏥'
        ],
        'ieee-style' => [
            'name' => 'IEEE Style',
            'description' => 'IEEE citation style',
            'icon' => '⚡'
        ],
        'ama-style' => [
            'name' => 'AMA Style',
            'description' => 'American Medical Association style',
            'icon' => '⚕️'
        ],
        'bluebook-style' => [
            'name' => 'Bluebook Style',
            'description' => 'Legal citation format',
            'icon' => '⚖️'
        ]
    ],
    
    'creative-formats' => [
        'vertical-text' => [
            'name' => 'Vertical Text',
            'description' => 'Display text vertically',
            'icon' => '📐'
        ],
        'reversed-text' => [
            'name' => 'Reversed Text',
            'description' => 'Reverse the text order',
            'icon' => '⬅️'
        ],
        'mirrored-text' => [
            'name' => 'Mirrored Text',
            'description' => 'Mirror the text horizontally',
            'icon' => '🪞'
        ],
        'upside-down' => [
            'name' => 'Upside Down',
            'description' => 'Flip text upside down',
            'icon' => '🙃'
        ],
        'diagonal-text' => [
            'name' => 'Diagonal Text',
            'description' => 'Display text diagonally',
            'icon' => '↗️'
        ],
        'wave-text' => [
            'name' => 'Wave Text',
            'description' => 'Create wavy text effect',
            'icon' => '🌊'
        ],
        'circle-text' => [
            'name' => 'Circle Text',
            'description' => 'Arrange text in a circle',
            'icon' => '⭕'
        ],
        'zigzag-text' => [
            'name' => 'Zigzag Text',
            'description' => 'Create zigzag text pattern',
            'icon' => '⚡'
        ],
        'pyramid-text' => [
            'name' => 'Pyramid Text',
            'description' => 'Arrange text in pyramid shape',
            'icon' => '🔺'
        ],
        'spiral-text' => [
            'name' => 'Spiral Text',
            'description' => 'Create spiral text effect',
            'icon' => '🌀'
        ],
        'rainbow-text' => [
            'name' => 'Rainbow Text',
            'description' => 'Add rainbow colors to text',
            'icon' => '🌈'
        ]
    ],
    
    'business-formats' => [
        'email-format' => [
            'name' => 'Email Format',
            'description' => 'Professional email formatting',
            'icon' => '📧'
        ],
        'business-letter' => [
            'name' => 'Business Letter',
            'description' => 'Formal business letter format',
            'icon' => '✉️'
        ],
        'memo-format' => [
            'name' => 'Memo Format',
            'description' => 'Business memorandum format',
            'icon' => '📋'
        ],
        'invoice-format' => [
            'name' => 'Invoice Format',
            'description' => 'Professional invoice layout',
            'icon' => '🧾'
        ],
        'proposal-format' => [
            'name' => 'Proposal Format',
            'description' => 'Business proposal structure',
            'icon' => '📑'
        ],
        'resume-format' => [
            'name' => 'Resume Format',
            'description' => 'Professional resume layout',
            'icon' => '📄'
        ],
        'report-format' => [
            'name' => 'Report Format',
            'description' => 'Business report structure',
            'icon' => '📊'
        ],
        'contract-format' => [
            'name' => 'Contract Format',
            'description' => 'Legal contract formatting',
            'icon' => '📜'
        ]
    ],
    
    'social-media-formats' => [
        'twitter-thread' => [
            'name' => 'Twitter Thread',
            'description' => 'Format text for Twitter threads',
            'icon' => '🐦'
        ],
        'instagram-caption' => [
            'name' => 'Instagram Caption',
            'description' => 'Format Instagram captions',
            'icon' => '📸'
        ],
        'linkedin-post' => [
            'name' => 'LinkedIn Post',
            'description' => 'Professional LinkedIn formatting',
            'icon' => '💼'
        ],
        'facebook-post' => [
            'name' => 'Facebook Post',
            'description' => 'Format for Facebook posts',
            'icon' => '👍'
        ],
        'youtube-description' => [
            'name' => 'YouTube Description',
            'description' => 'Format YouTube descriptions',
            'icon' => '▶️'
        ],
        'tiktok-caption' => [
            'name' => 'TikTok Caption',
            'description' => 'Format TikTok captions',
            'icon' => '🎵'
        ],
        'reddit-post' => [
            'name' => 'Reddit Post',
            'description' => 'Format Reddit posts',
            'icon' => '🔴'
        ],
        'discord-message' => [
            'name' => 'Discord Message',
            'description' => 'Format Discord messages',
            'icon' => '💬'
        ]
    ],
    
    'technical-documentation' => [
        'markdown-format' => [
            'name' => 'Markdown Format',
            'description' => 'Convert to Markdown syntax',
            'icon' => '📝'
        ],
        'rst-format' => [
            'name' => 'RST Format',
            'description' => 'reStructuredText format',
            'icon' => '📄'
        ],
        'api-docs' => [
            'name' => 'API Docs',
            'description' => 'API documentation format',
            'icon' => '📡'
        ],
        'jsdoc-format' => [
            'name' => 'JSDoc Format',
            'description' => 'JavaScript documentation',
            'icon' => '📖'
        ],
        'javadoc-format' => [
            'name' => 'JavaDoc Format',
            'description' => 'Java documentation format',
            'icon' => '☕'
        ],
        'phpdoc-format' => [
            'name' => 'PHPDoc Format',
            'description' => 'PHP documentation format',
            'icon' => '🐘'
        ],
        'docstring-format' => [
            'name' => 'Docstring Format',
            'description' => 'Python docstring format',
            'icon' => '🐍'
        ],
        'sphinx-format' => [
            'name' => 'Sphinx Format',
            'description' => 'Sphinx documentation format',
            'icon' => '🔧'
        ]
    ],
    
    'international-formats' => [
        'british-english' => [
            'name' => 'British English',
            'description' => 'Convert to British spelling',
            'icon' => '🇬🇧'
        ],
        'american-english' => [
            'name' => 'American English',
            'description' => 'Convert to American spelling',
            'icon' => '🇺🇸'
        ],
        'canadian-english' => [
            'name' => 'Canadian English',
            'description' => 'Convert to Canadian spelling',
            'icon' => '🇨🇦'
        ],
        'australian-english' => [
            'name' => 'Australian English',
            'description' => 'Convert to Australian spelling',
            'icon' => '🇦🇺'
        ],
        'simplified-chinese' => [
            'name' => 'Simplified Chinese',
            'description' => 'Convert to simplified Chinese',
            'icon' => '🇨🇳'
        ],
        'traditional-chinese' => [
            'name' => 'Traditional Chinese',
            'description' => 'Convert to traditional Chinese',
            'icon' => '🇹🇼'
        ],
        'european-date' => [
            'name' => 'European Date',
            'description' => 'DD/MM/YYYY format',
            'icon' => '🇪🇺'
        ],
        'us-date' => [
            'name' => 'US Date',
            'description' => 'MM/DD/YYYY format',
            'icon' => '🇺🇸'
        ]
    ],
    
    'utility-transformations' => [
        'remove-spaces' => [
            'name' => 'Remove Spaces',
            'description' => 'Remove all spaces from text',
            'icon' => '🔽'
        ],
        'trim-text' => [
            'name' => 'Trim Text',
            'description' => 'Remove leading and trailing spaces',
            'icon' => '✂️'
        ],
        'add-line-numbers' => [
            'name' => 'Add Line Numbers',
            'description' => 'Number each line of text',
            'icon' => '🔢'
        ],
        'remove-line-numbers' => [
            'name' => 'Remove Line Numbers',
            'description' => 'Remove line numbers from text',
            'icon' => '❌'
        ],
        'sort-lines' => [
            'name' => 'Sort Lines',
            'description' => 'Sort lines alphabetically',
            'icon' => '📊'
        ],
        'reverse-lines' => [
            'name' => 'Reverse Lines',
            'description' => 'Reverse the order of lines',
            'icon' => '🔄'
        ],
        'unique-lines' => [
            'name' => 'Unique Lines',
            'description' => 'Remove duplicate lines',
            'icon' => '1️⃣'
        ],
        'shuffle-lines' => [
            'name' => 'Shuffle Lines',
            'description' => 'Randomly shuffle lines',
            'icon' => '🎲'
        ],
        'wrap-text' => [
            'name' => 'Wrap Text',
            'description' => 'Wrap text at specified width',
            'icon' => '📏'
        ],
        'unwrap-text' => [
            'name' => 'Unwrap Text',
            'description' => 'Remove line breaks within paragraphs',
            'icon' => '📐'
        ],
        'indent-text' => [
            'name' => 'Indent Text',
            'description' => 'Add indentation to text',
            'icon' => '➡️'
        ],
        'outdent-text' => [
            'name' => 'Outdent Text',
            'description' => 'Remove indentation from text',
            'icon' => '⬅️'
        ]
    ],
    
    'text-effects' => [
        'bold-text' => [
            'name' => 'Bold Text',
            'description' => 'Convert to bold Unicode characters',
            'icon' => '🅱️'
        ],
        'italic-text' => [
            'name' => 'Italic Text',
            'description' => 'Convert to italic Unicode characters',
            'icon' => '📖'
        ],
        'underline-text' => [
            'name' => 'Underline Text',
            'description' => 'Add underline to text',
            'icon' => '_'
        ],
        'strike-through' => [
            'name' => 'Strike Through',
            'description' => 'Add strikethrough effect',
            'icon' => '➖'
        ],
        'double-struck' => [
            'name' => 'Double Struck',
            'description' => 'Convert to double-struck characters',
            'icon' => '𝔻'
        ],
        'cursive-text' => [
            'name' => 'Cursive Text',
            'description' => 'Convert to cursive Unicode',
            'icon' => '✍️'
        ],
        'small-caps' => [
            'name' => 'Small Caps',
            'description' => 'Convert to small capital letters',
            'icon' => 'ᴀ'
        ],
        'superscript' => [
            'name' => 'Superscript',
            'description' => 'Convert to superscript characters',
            'icon' => '²'
        ],
        'subscript' => [
            'name' => 'Subscript',
            'description' => 'Convert to subscript characters',
            'icon' => '₂'
        ],
        'wide-text' => [
            'name' => 'Wide Text',
            'description' => 'Convert to full-width characters',
            'icon' => '🅆'
        ],
        'bubble-text' => [
            'name' => 'Bubble Text',
            'description' => 'Convert to bubble letters',
            'icon' => '🅾️'
        ],
        'square-text' => [
            'name' => 'Square Text',
            'description' => 'Convert to square letters',
            'icon' => '🔲'
        ]
    ],
    
    'generators' => [
        'lorem-ipsum' => [
            'name' => 'Lorem Ipsum',
            'description' => 'Generate Lorem Ipsum text',
            'icon' => '📝'
        ],
        'random-text' => [
            'name' => 'Random Text',
            'description' => 'Generate random text',
            'icon' => '🎲'
        ],
        'random-password' => [
            'name' => 'Random Password',
            'description' => 'Generate secure password',
            'icon' => '🔐'
        ],
        'uuid-generator' => [
            'name' => 'UUID Generator',
            'description' => 'Generate unique identifier',
            'icon' => '🆔'
        ],
        'random-name' => [
            'name' => 'Random Name',
            'description' => 'Generate random names',
            'icon' => '👤'
        ],
        'random-email' => [
            'name' => 'Random Email',
            'description' => 'Generate random email addresses',
            'icon' => '📧'
        ],
        'random-date' => [
            'name' => 'Random Date',
            'description' => 'Generate random dates',
            'icon' => '📅'
        ],
        'random-color' => [
            'name' => 'Random Color',
            'description' => 'Generate random color codes',
            'icon' => '🎨'
        ],
        'random-number' => [
            'name' => 'Random Number',
            'description' => 'Generate random numbers',
            'icon' => '🔢'
        ],
        'random-ip' => [
            'name' => 'Random IP',
            'description' => 'Generate random IP addresses',
            'icon' => '🌐'
        ],
        'random-url' => [
            'name' => 'Random URL',
            'description' => 'Generate random URLs',
            'icon' => '🔗'
        ],
        'random-phone' => [
            'name' => 'Random Phone',
            'description' => 'Generate random phone numbers',
            'icon' => '📱'
        ],
        'random-address' => [
            'name' => 'Random Address',
            'description' => 'Generate random addresses',
            'icon' => '🏠'
        ]
    ],
    
    'code-data-tools' => [
        'json-format' => [
            'name' => 'JSON Format',
            'description' => 'Format and validate JSON',
            'icon' => '{ }'
        ],
        'json-minify' => [
            'name' => 'JSON Minify',
            'description' => 'Minify JSON data',
            'icon' => '📉'
        ],
        'json-escape' => [
            'name' => 'JSON Escape',
            'description' => 'Escape JSON strings',
            'icon' => '🔒'
        ],
        'json-unescape' => [
            'name' => 'JSON Unescape',
            'description' => 'Unescape JSON strings',
            'icon' => '🔓'
        ],
        'xml-format' => [
            'name' => 'XML Format',
            'description' => 'Format XML documents',
            'icon' => '📄'
        ],
        'xml-minify' => [
            'name' => 'XML Minify',
            'description' => 'Minify XML data',
            'icon' => '📉'
        ],
        'xml-escape' => [
            'name' => 'XML Escape',
            'description' => 'Escape XML entities',
            'icon' => '🔒'
        ],
        'xml-unescape' => [
            'name' => 'XML Unescape',
            'description' => 'Unescape XML entities',
            'icon' => '🔓'
        ],
        'html-encode' => [
            'name' => 'HTML Encode',
            'description' => 'Encode HTML entities',
            'icon' => '🌐'
        ],
        'html-decode' => [
            'name' => 'HTML Decode',
            'description' => 'Decode HTML entities',
            'icon' => '📖'
        ],
        'url-encode' => [
            'name' => 'URL Encode',
            'description' => 'URL encode text',
            'icon' => '🔗'
        ],
        'url-decode' => [
            'name' => 'URL Decode',
            'description' => 'URL decode text',
            'icon' => '🔓'
        ],
        'base64-encode' => [
            'name' => 'Base64 Encode',
            'description' => 'Encode to Base64',
            'icon' => '🔐'
        ],
        'base64-decode' => [
            'name' => 'Base64 Decode',
            'description' => 'Decode from Base64',
            'icon' => '🔑'
        ],
        'hex-encode' => [
            'name' => 'Hex Encode',
            'description' => 'Convert to hexadecimal',
            'icon' => '#'
        ],
        'binary-encode' => [
            'name' => 'Binary Encode',
            'description' => 'Convert to binary',
            'icon' => '01'
        ]
    ],
    
    'image-converters' => [
        'text-to-ascii-art' => [
            'name' => 'Text to ASCII Art',
            'description' => 'Convert text to ASCII art',
            'icon' => '🎨'
        ],
        'image-to-base64' => [
            'name' => 'Image to Base64',
            'description' => 'Convert image to Base64',
            'icon' => '🖼️'
        ],
        'svg-to-base64' => [
            'name' => 'SVG to Base64',
            'description' => 'Convert SVG to Base64',
            'icon' => '🎨'
        ],
        'emoji-to-unicode' => [
            'name' => 'Emoji to Unicode',
            'description' => 'Convert emoji to Unicode',
            'icon' => '😀'
        ],
        'unicode-to-emoji' => [
            'name' => 'Unicode to Emoji',
            'description' => 'Convert Unicode to emoji',
            'icon' => '🔣'
        ],
        'text-to-qrcode' => [
            'name' => 'Text to QR Code',
            'description' => 'Generate QR code from text',
            'icon' => '📱'
        ],
        'text-to-barcode' => [
            'name' => 'Text to Barcode',
            'description' => 'Generate barcode from text',
            'icon' => '📊'
        ],
        'color-code-converter' => [
            'name' => 'Color Code Converter',
            'description' => 'Convert between color formats',
            'icon' => '🎨'
        ],
        'font-converter' => [
            'name' => 'Font Converter',
            'description' => 'Convert between font formats',
            'icon' => '🔤'
        ]
    ],
    
    'text-analysis' => [
        'word-counter' => [
            'name' => 'Word Counter',
            'description' => 'Count words in text',
            'icon' => '🔢'
        ],
        'character-counter' => [
            'name' => 'Character Counter',
            'description' => 'Count characters in text',
            'icon' => '📏'
        ],
        'line-counter' => [
            'name' => 'Line Counter',
            'description' => 'Count lines in text',
            'icon' => '📊'
        ],
        'reading-time' => [
            'name' => 'Reading Time',
            'description' => 'Calculate reading time',
            'icon' => '⏱️'
        ],
        'keyword-density' => [
            'name' => 'Keyword Density',
            'description' => 'Analyze keyword density',
            'icon' => '📈'
        ],
        'sentiment-analysis' => [
            'name' => 'Sentiment Analysis',
            'description' => 'Analyze text sentiment',
            'icon' => '😊'
        ],
        'readability-score' => [
            'name' => 'Readability Score',
            'description' => 'Calculate readability score',
            'icon' => '📖'
        ],
        'language-detector' => [
            'name' => 'Language Detector',
            'description' => 'Detect text language',
            'icon' => '🌐'
        ]
    ],
    
    'text-cleanup' => [
        'remove-duplicates' => [
            'name' => 'Remove Duplicates',
            'description' => 'Remove duplicate lines',
            'icon' => '🔄'
        ],
        'remove-empty-lines' => [
            'name' => 'Remove Empty Lines',
            'description' => 'Remove blank lines',
            'icon' => '❌'
        ],
        'remove-html-tags' => [
            'name' => 'Remove HTML Tags',
            'description' => 'Strip HTML from text',
            'icon' => '🏷️'
        ],
        'remove-punctuation' => [
            'name' => 'Remove Punctuation',
            'description' => 'Remove all punctuation',
            'icon' => '.'
        ],
        'remove-numbers' => [
            'name' => 'Remove Numbers',
            'description' => 'Remove all numbers',
            'icon' => '🔢'
        ],
        'remove-special-chars' => [
            'name' => 'Remove Special Chars',
            'description' => 'Remove special characters',
            'icon' => '@'
        ],
        'normalize-whitespace' => [
            'name' => 'Normalize Whitespace',
            'description' => 'Fix irregular spacing',
            'icon' => '📐'
        ],
        'fix-encoding' => [
            'name' => 'Fix Encoding',
            'description' => 'Fix text encoding issues',
            'icon' => '🔧'
        ]
    ],
    
    'social-media-generators' => [
        'hashtag-generator' => [
            'name' => 'Hashtag Generator',
            'description' => 'Generate relevant hashtags',
            'icon' => '#'
        ],
        'twitter-font' => [
            'name' => 'Twitter Font',
            'description' => 'Special Twitter fonts',
            'icon' => '🐦'
        ],
        'instagram-font' => [
            'name' => 'Instagram Font',
            'description' => 'Instagram bio fonts',
            'icon' => '📸'
        ],
        'emoji-translator' => [
            'name' => 'Emoji Translator',
            'description' => 'Convert text to emojis',
            'icon' => '😀'
        ],
        'bio-generator' => [
            'name' => 'Bio Generator',
            'description' => 'Generate social media bio',
            'icon' => '👤'
        ],
        'caption-generator' => [
            'name' => 'Caption Generator',
            'description' => 'Generate post captions',
            'icon' => '💬'
        ],
        'username-generator' => [
            'name' => 'Username Generator',
            'description' => 'Generate unique usernames',
            'icon' => '@'
        ],
        'handle-checker' => [
            'name' => 'Handle Checker',
            'description' => 'Check username availability',
            'icon' => '✅'
        ]
    ],
    
    'miscellaneous' => [
        'morse-code' => [
            'name' => 'Morse Code',
            'description' => 'Convert to/from Morse code',
            'icon' => '📡'
        ],
        'binary-translator' => [
            'name' => 'Binary Translator',
            'description' => 'Convert to/from binary',
            'icon' => '01'
        ],
        'roman-numerals' => [
            'name' => 'Roman Numerals',
            'description' => 'Convert to/from Roman numerals',
            'icon' => 'Ⅷ'
        ],
        'nato-phonetic' => [
            'name' => 'NATO Phonetic',
            'description' => 'NATO phonetic alphabet',
            'icon' => '🎖️'
        ],
        'pig-latin' => [
            'name' => 'Pig Latin',
            'description' => 'Convert to Pig Latin',
            'icon' => '🐷'
        ],
        'leetspeak' => [
            'name' => 'Leetspeak',
            'description' => 'Convert to 1337 speak',
            'icon' => '1337'
        ],
        'zalgo-text' => [
            'name' => 'Zalgo Text',
            'description' => 'Create glitchy text',
            'icon' => '👹'
        ]
    ]
];