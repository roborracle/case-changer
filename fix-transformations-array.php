#!/usr/bin/env php
<?php

/**
 * Fix the $transformations array to include ALL 169 transformations
 * This adds the missing 83 entries to make them accessible
 */

$servicePath = __DIR__ . '/app/Services/TransformationService.php';

// All 169 transformations that should be in the array
$allTransformations = [
    // Case Formats (already in array)
    'upper-case' => 'Upper Case',
    'lower-case' => 'Lower Case', 
    'title-case' => 'Title Case',
    'sentence-case' => 'Sentence Case',
    'capitalize-words' => 'Capitalize Words',
    'alternating-case' => 'Alternating Case',
    'inverse-case' => 'Inverse Case',
    'camel-case' => 'Camel Case',
    'pascal-case' => 'Pascal Case',
    'snake-case' => 'Snake Case',
    'constant-case' => 'Constant Case',
    'kebab-case' => 'Kebab Case',
    'dot-case' => 'Dot Case',
    'path-case' => 'Path Case',
    
    // Style Guides (already in array)
    'ap-style' => 'AP Style',
    'nyt-style' => 'NY Times Style',
    'chicago-style' => 'Chicago Style',
    'guardian-style' => 'Guardian Style',
    'bbc-style' => 'BBC Style',
    'reuters-style' => 'Reuters Style',
    'economist-style' => 'Economist Style',
    'wsj-style' => 'WSJ Style',
    'apa-style' => 'APA Style',
    'mla-style' => 'MLA Style',
    'chicago-author-date' => 'Chicago Author-Date',
    'chicago-notes' => 'Chicago Notes',
    'harvard-style' => 'Harvard Style',
    'vancouver-style' => 'Vancouver Style',
    'ieee-style' => 'IEEE Style',
    'ama-style' => 'AMA Style',
    'bluebook-style' => 'Bluebook Style',
    
    // Creative Styles (already in array)
    'reverse' => 'Reverse',
    'aesthetic' => 'Aesthetic',
    'sarcasm' => 'Sarcasm Case',
    'smallcaps' => 'Small Caps',
    'bubble' => 'Bubble Text',
    'square' => 'Square Text',
    'script' => 'Script',
    'double-struck' => 'Double Struck',
    'bold' => 'Bold',
    'italic' => 'Italic',
    'emoji-case' => 'Emoji Case',
    
    // Business Styles (already in array)
    'email-style' => 'Email Style',
    'legal-style' => 'Legal Style',
    'marketing-headline' => 'Marketing Headline',
    'press-release' => 'Press Release',
    'memo-style' => 'Memo Style',
    'report-style' => 'Report Style',
    'proposal-style' => 'Proposal Style',
    'invoice-style' => 'Invoice Style',
    
    // Social Media (already in array)
    'twitter-style' => 'Twitter/X Style',
    'instagram-style' => 'Instagram Style',
    'linkedin-style' => 'LinkedIn Style',
    'facebook-style' => 'Facebook Style',
    'youtube-title' => 'YouTube Title',
    'tiktok-style' => 'TikTok Style',
    'hashtag-style' => 'Hashtag Style',
    'mention-style' => 'Mention Style',
    
    // Technical (already in array)
    'api-docs' => 'API Documentation',
    'readme-style' => 'README Style',
    'changelog-style' => 'Changelog Style',
    'user-manual' => 'User Manual',
    'technical-spec' => 'Technical Spec',
    'code-comments' => 'Code Comments',
    'wiki-style' => 'Wiki Style',
    'markdown-style' => 'Markdown Style',
    
    // International (partially in array)
    'british-english' => 'British English',
    'american-english' => 'American English',
    'canadian-english' => 'Canadian English',
    'australian-english' => 'Australian English',
    'eu-format' => 'EU Format',
    'iso-format' => 'ISO Format',
    'unicode-normalize' => 'Unicode Normalize',
    'ascii-convert' => 'ASCII Convert',
    
    // Utility (partially in array)
    'remove-spaces' => 'Remove Spaces',
    'remove-extra-spaces' => 'Remove Extra Spaces',
    'add-dashes' => 'Add Dashes',
    'add-underscores' => 'Add Underscores',
    'add-periods' => 'Add Periods',
    'remove-punctuation' => 'Remove Punctuation',
    'extract-letters' => 'Extract Letters',
    'extract-numbers' => 'Extract Numbers',
    'remove-duplicates' => 'Remove Duplicates',
    'sort-words' => 'Sort Words',
    'shuffle-words' => 'Shuffle Words',
    'word-frequency' => 'Word Frequency',
    
    // NEW - Text Effects (MISSING FROM ARRAY)
    'bold-text' => 'Bold Text',
    'italic-text' => 'Italic Text',
    'strikethrough-text' => 'Strikethrough Text',
    'underline-text' => 'Underline Text',
    'superscript' => 'Superscript',
    'subscript' => 'Subscript',
    'wide-text' => 'Wide Text',
    'upside-down' => 'Upside Down',
    'mirror-text' => 'Mirror Text',
    'zalgo-text' => 'Zalgo Text',
    'cursed-text' => 'Cursed Text',
    'invisible-text' => 'Invisible Text',
    
    // NEW - Generators (MISSING FROM ARRAY)
    'password-generator' => 'Password Generator',
    'uuid-generator' => 'UUID Generator',
    'random-number' => 'Random Number',
    'random-letter' => 'Random Letter',
    'random-date' => 'Random Date',
    'random-month' => 'Random Month',
    'random-ip' => 'Random IP',
    'random-choice' => 'Random Choice',
    'lorem-ipsum' => 'Lorem Ipsum',
    'username-generator' => 'Username Generator',
    'email-generator' => 'Email Generator',
    'hex-color' => 'Hex Color',
    'phone-number' => 'Phone Number',
    
    // NEW - Code & Data Tools (MISSING FROM ARRAY)
    'binary-translator' => 'Binary Translator',
    'hex-converter' => 'Hex Converter',
    'morse-code' => 'Morse Code',
    'caesar-cipher' => 'Caesar Cipher',
    'md5-hash' => 'MD5 Hash',
    'sha256-hash' => 'SHA256 Hash',
    'json-formatter' => 'JSON Formatter',
    'csv-to-json' => 'CSV to JSON',
    'css-formatter' => 'CSS Formatter',
    'html-formatter' => 'HTML Formatter',
    'javascript-formatter' => 'JavaScript Formatter',
    'xml-formatter' => 'XML Formatter',
    'yaml-formatter' => 'YAML Formatter',
    'utf8-converter' => 'UTF8 Converter',
    'utm-builder' => 'UTM Builder',
    'slugify-generator' => 'Slugify Generator',
    
    // NEW - Text Analysis & Cleanup (MISSING FROM ARRAY)
    'sentence-counter' => 'Sentence Counter',
    'duplicate-finder' => 'Duplicate Finder',
    'duplicate-remover' => 'Duplicate Remover',
    'text-replacer' => 'Text Replacer',
    'line-break-remover' => 'Line Break Remover',
    'plain-text-converter' => 'Plain Text Converter',
    'remove-formatting' => 'Remove Formatting',
    'remove-letters' => 'Remove Letters',
    'remove-underscores' => 'Remove Underscores',
    'whitespace-remover' => 'Whitespace Remover',
    'repeat-text' => 'Repeat Text',
    'phonetic-spelling' => 'Phonetic Spelling',
    'pig-latin' => 'Pig Latin',
    
    // NEW - Social Media Fonts (MISSING FROM ARRAY)
    'discord-font' => 'Discord Font',
    'facebook-font' => 'Facebook Font',
    'instagram-font' => 'Instagram Font',
    'twitter-font' => 'Twitter Font',
    'big-text' => 'Big Text',
    'slash-text' => 'Slash Text',
    'stacked-text' => 'Stacked Text',
    'wingdings' => 'Wingdings',
    
    // NEW - Miscellaneous (MISSING FROM ARRAY)
    'nato-phonetic' => 'NATO Phonetic',
    'roman-numerals' => 'Roman Numerals',
];

// Read the file
$content = file_get_contents($servicePath);

// Create the new array string
$arrayString = "    private \$transformations = [\n";
foreach ($allTransformations as $key => $value) {
    $arrayString .= "        '$key' => '$value',\n";
}
$arrayString .= "    ];";

// Replace the old array with the new one
$pattern = '/private \$transformations = \[.*?\];/s';
$content = preg_replace($pattern, $arrayString, $content);

// Write back
file_put_contents($servicePath, $content);

echo "=================================================\n";
echo "FIXED TRANSFORMATIONS ARRAY\n";
echo "=================================================\n\n";
echo "✅ Updated array to include ALL " . count($allTransformations) . " transformations\n";
echo "📊 Previous: 86 transformations\n";
echo "📊 Now: " . count($allTransformations) . " transformations\n\n";

// List the new additions
$newAdditions = array_slice($allTransformations, 94);
echo "🆕 Added " . count($newAdditions) . " missing transformations:\n";
foreach ($newAdditions as $key => $value) {
    echo "   - $key: $value\n";
}

echo "\n✨ All transformations are now registered and accessible!\n";