<?php

namespace App\Services;

class PlaceholderService
{
    /**
     * Get placeholder text for a specific transformation
     */
    public function getPlaceholder($transformation, $styleGuide = null)
    {
        // Style guide specific placeholders for Title Case
        if ($transformation === 'title-case' && $styleGuide) {
            return $this->getStyleGuidePlaceholder($styleGuide);
        }
        
        // Regular transformation placeholders
        return $this->getTransformationPlaceholder($transformation);
    }
    
    /**
     * Get example output for a transformation
     */
    public function getExample($transformation, $styleGuide = null)
    {
        $baseText = "the quick brown fox jumps over the lazy dog";
        
        if ($transformation === 'title-case' && $styleGuide) {
            return $this->getStyleGuideExample($styleGuide);
        }
        
        return $this->transformExample($baseText, $transformation);
    }
    
    /**
     * Style guide specific placeholders
     */
    private function getStyleGuidePlaceholder($styleGuide)
    {
        $placeholders = [
            'ap' => "Enter Text to Convert to AP Style: 'The President of the United States'. Articles Stay Lowercase.",
            'apa' => "Enter Text for APA Style: 'The Psychology of Learning: A New Approach'. Major Words Capitalized.",
            'chicago' => "Enter Text for Chicago Style: 'A History of the World in Ten Chapters'. Prepositions Under Five Letters Lowercase.",
            'mla' => "Enter Text for MLA Style: 'Writing About Literature: A Guide for Students'. First and Last Words Always Capitalized.",
            'nyt' => "Enter Text for New York Times Style: 'Scientists Discover New Species in the Amazon'. Similar to AP Style.",
            'wikipedia' => "Enter Text for Wikipedia Style: 'History of the Internet'. Simple Title Case with Minimal Capitalization.",
            'bluebook' => "Enter Text for Bluebook Legal Style: 'Constitutional Law and the First Amendment'. Legal Citation Format.",
            'ama' => "Enter Text for AMA Medical Style: 'Treatment of Diabetes with Insulin'. Medical Journal Standards."
        ];
        
        return $placeholders[$styleGuide] ?? "Enter your text here to apply {$styleGuide} style formatting";
    }
    
    /**
     * Transformation specific placeholders
     */
    private function getTransformationPlaceholder($transformation)
    {
        $placeholders = [
            // Case Conversions
            'upper-case' => "Enter text to convert to UPPERCASE. Example: THIS IS ALL UPPERCASE TEXT",
            'lower-case' => "Enter text to convert to lowercase. Example: this is all lowercase text",
            'title-case' => "Enter text to convert to Title Case. Example: This Is Title Case Text",
            'sentence-case' => "Enter text to convert to sentence case. Example: This is sentence case. Each sentence starts capitalized.",
            'capitalize-words' => "Enter text to Capitalize Every Word. Example: Every Single Word Is Capitalized",
            'alternating-case' => "Enter text for aLtErNaTiNg CaSe. Example: tHiS tExT aLtErNaTeS",
            'inverse-case' => "Enter text to INVERSE case. Example: iNVERSE cASE sWAPS uPPER aND lOWER",
            
            // Developer Formats
            'camel-case' => "Enter text for camelCase. Example: thisIsCamelCaseFormat",
            'pascal-case' => "Enter text for PascalCase. Example: ThisIsPascalCaseFormat",
            'snake-case' => "Enter text for snake_case. Example: this_is_snake_case_format",
            'kebab-case' => "Enter text for kebab-case. Example: this-is-kebab-case-format",
            'constant-case' => "Enter text for CONSTANT_CASE. Example: THIS_IS_CONSTANT_CASE_FORMAT",
            'dot-case' => "Enter text for dot.case. Example: this.is.dot.case.format",
            'path-case' => "Enter text for path/case. Example: this/is/path/case/format",
            'train-case' => "Enter text for Train-Case. Example: This-Is-Train-Case-Format",
            
            // Creative Formats
            'spongebob-case' => "Enter text for SpOnGeBoB MoCkInG. Example: tHiS iS sPoNgEbOb TeXt",
            'clap-case' => "Enter text for 👏 clap 👏 case. Example: this 👏 has 👏 claps 👏 between",
            'reverse-text' => "Enter text to reverse. Example: txet desrever si sihT",
            'upside-down' => "Enter text to flip upside down. Example: ʇxǝʇ uʍop ǝpısdn sı sıɥʇ",
            'wide-text' => "Enter text for ｗｉｄｅ spacing. Example: ｔｈｉｓ　ｉｓ　ｗｉｄｅ　ｔｅｘｔ",
            'zalgo-text' => "Enter text for z̴̢̈́ä̵́ͅl̷̰̈g̶̱̈ó creepy effect",
            
            // Social Media
            'hashtag-generator' => "Enter text to create #hashtags. Example: #ThisCreatesHashtags #FromYourText",
            'mention-generator' => "Enter usernames to create @mentions. Example: @user1 @user2 @user3",
            
            // Utilities
            'remove-accents' => "Enter text with àccénts to remove them. Example: accents become regular letters",
            'remove-spaces' => "Enter text to remove spaces. Example: textwithnospaces",
            'remove-duplicates' => "Enter text to remove duplicate duplicate words. Example: removes duplicate words",
            'word-frequency' => "Enter text to analyze word frequency and count occurrences",
            'character-count' => "Enter text to count characters, words, lines, and paragraphs",
            
            // Text Effects
            'bold-text' => "Enter text for 𝐛𝐨𝐥𝐝 style. Example: 𝐓𝐡𝐢𝐬 𝐢𝐬 𝐛𝐨𝐥𝐝 𝐭𝐞𝐱𝐭",
            'italic-text' => "Enter text for 𝘪𝘵𝘢𝘭𝘪𝘤 style. Example: 𝘛𝘩𝘪𝘴 𝘪𝘴 𝘪𝘵𝘢𝘭𝘪𝘤 𝘵𝘦𝘹𝘵",
            'strikethrough' => "Enter text for s̶t̶r̶i̶k̶e̶t̶h̶r̶o̶u̶g̶h̶. Example: t̶h̶i̶s̶ ̶i̶s̶ ̶s̶t̶r̶u̶c̶k̶",
            'underline' => "Enter text to u̲n̲d̲e̲r̲l̲i̲n̲e̲. Example: t̲h̲i̲s̲ ̲i̲s̲ ̲u̲n̲d̲e̲r̲l̲i̲n̲e̲d̲",
            'bubble-text' => "Enter text for ⓑⓤⓑⓑⓛⓔ letters. Example: ⓣⓗⓘⓢ ⓘⓢ ⓑⓤⓑⓑⓛⓔ",
            'square-text' => "Enter text for 🅂🅀🅄🄰🅁🄴 letters. Example: 🅃🄷🄸🅂 🄸🅂 🅂🅀🅄🄰🅁🄴",
            
            // Encoding
            'base64-encode' => "Enter text to encode in Base64. Example: VGhpcyBpcyBCYXNlNjQ=",
            'base64-decode' => "Enter Base64 to decode. Example: VGhpcyBpcyBCYXNlNjQ= becomes readable text",
            'url-encode' => "Enter text to URL encode. Example: text%20with%20spaces",
            'url-decode' => "Enter URL encoded text to decode. Example: text%20with%20spaces becomes normal",
            'html-encode' => "Enter text with <html> to encode. Example: &lt;html&gt; entities",
            'html-decode' => "Enter &lt;html&gt; entities to decode. Example: <html> tags",
            
            // Binary/Morse
            'binary-encode' => "Enter text for binary. Example: 01110100 01100101 01111000 01110100",
            'morse-code' => "Enter text for Morse code. Example: - . -..- - / .. -. / -- --- .-. ... .",
            'nato-phonetic' => "Enter text for NATO alphabet. Example: Tango Echo X-ray Tango",
            
            // Default
            'default' => "Enter or paste your text here to transform it"
        ];
        
        return $placeholders[$transformation] ?? $placeholders['default'];
    }
    
    /**
     * Get style guide examples
     */
    private function getStyleGuideExample($styleGuide)
    {
        $examples = [
            'ap' => "The President of the United States Visits the White House",
            'apa' => "The Psychology of Learning: A Comprehensive Guide to Education",
            'chicago' => "A History of Art in the Renaissance: From Italy to France",
            'mla' => "Understanding Shakespeare: The Complete Works and Their Impact",
            'nyt' => "Scientists Discover New Planet in Distant Solar System",
            'wikipedia' => "History of the Internet",
            'bluebook' => "Constitutional Law and the First Amendment: A Legal Analysis",
            'ama' => "Treatment of Type 2 Diabetes with Novel Therapeutic Approaches"
        ];
        
        return $examples[$styleGuide] ?? "Title Case Example Text";
    }
    
    /**
     * Transform example text
     */
    private function transformExample($text, $transformation)
    {
        switch($transformation) {
            case 'upper-case':
                return strtoupper($text);
            case 'lower-case':
                return strtolower($text);
            case 'title-case':
                return ucwords($text);
            case 'sentence-case':
                return ucfirst(strtolower($text));
            case 'camel-case':
                return lcfirst(str_replace(' ', '', ucwords($text)));
            case 'pascal-case':
                return str_replace(' ', '', ucwords($text));
            case 'snake-case':
                return str_replace(' ', '_', strtolower($text));
            case 'kebab-case':
                return str_replace(' ', '-', strtolower($text));
            case 'constant-case':
                return str_replace(' ', '_', strtoupper($text));
            default:
                return $text;
        }
    }
}