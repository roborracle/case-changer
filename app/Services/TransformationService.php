<?php

namespace App\Services;

/**
 * TransformationService - Core text transformation engine
 * 
 * Handles all case transformations with proper separation of concerns.
 * Follows SCARLETT architecture principles for modular, maintainable code.
 * 
 * @package App\Services
 * @version 1.0.0
 */
class TransformationService
{
    /**
     * Transform text to title case
     * 
     * @param string $text Input text to transform
     * @return string Transformed text in title case
     */
    public function toTitleCase(string $text): string
    {
        $text = mb_strtolower($text);
        return mb_convert_case($text, MB_CASE_TITLE, "UTF-8");
    }

    /**
     * Transform text to sentence case
     * 
     * @param string $text Input text to transform
     * @return string Transformed text in sentence case
     */
    public function toSentenceCase(string $text): string
    {
        $text = mb_strtolower($text);
        $sentences = preg_split('/([.!?]+\s*)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
        $result = '';
        
        foreach ($sentences as $i => $sentence) {
            if ($i % 2 == 0 && trim($sentence) !== '') {
                $trimmed = trim($sentence);
                if (mb_strlen($trimmed) > 0) {
                    $firstChar = mb_strtoupper(mb_substr($trimmed, 0, 1));
                    $rest = mb_substr($trimmed, 1);
                    $result .= $firstChar . $rest;
                } else {
                    $result .= $sentence;
                }
            } else {
                $result .= $sentence;
            }
        }
        
        return $result;
    }

    /**
     * Transform text to UPPERCASE
     * 
     * @param string $text Input text to transform
     * @return string Transformed text in UPPERCASE
     */
    public function toUpperCase(string $text): string
    {
        return mb_strtoupper($text);
    }

    /**
     * Transform text to lowercase
     * 
     * @param string $text Input text to transform
     * @return string Transformed text in lowercase
     */
    public function toLowerCase(string $text): string
    {
        return mb_strtolower($text);
    }

    /**
     * Capitalize first letter of each word
     * 
     * @param string $text Input text to transform
     * @return string Transformed text with first letters capitalized
     */
    public function toFirstLetter(string $text): string
    {
        return mb_convert_case($text, MB_CASE_TITLE, "UTF-8");
    }

    /**
     * Transform text to aLtErNaTiNg case
     * 
     * @param string $text Input text to transform
     * @return string Transformed text in alternating case
     */
    public function toAlternatingCase(string $text): string
    {
        $result = '';
        $upper = false;
        $chars = mb_str_split($text);
        
        foreach ($chars as $char) {
            if (preg_match('/\p{L}/u', $char)) {
                $result .= $upper ? mb_strtoupper($char) : mb_strtolower($char);
                $upper = !$upper;
            } else {
                $result .= $char;
            }
        }
        
        return $result;
    }

    /**
     * Transform text to RaNdOm case
     * 
     * @param string $text Input text to transform
     * @return string Transformed text in random case
     */
    public function toRandomCase(string $text): string
    {
        $result = '';
        $chars = mb_str_split($text);
        
        foreach ($chars as $char) {
            if (preg_match('/\p{L}/u', $char)) {
                $result .= rand(0, 1) ? mb_strtoupper($char) : mb_strtolower($char);
            } else {
                $result .= $char;
            }
        }
        
        return $result;
    }

    /**
     * Transform text to camelCase
     * 
     * @param string $text Input text to transform
     * @return string Transformed text in camelCase
     */
    public function toCamelCase(string $text): string
    {
        $text = preg_replace('/[^a-zA-Z0-9]+/', ' ', $text);
        $text = trim($text);
        $text = ucwords($text);
        $text = str_replace(' ', '', $text);
        return lcfirst($text);
    }

    /**
     * Transform text to snake_case
     * 
     * @param string $text Input text to transform
     * @return string Transformed text in snake_case
     */
    public function toSnakeCase(string $text): string
    {
        $text = preg_replace('/[^a-zA-Z0-9]+/', '_', $text);
        $text = preg_replace('/([a-z])([A-Z])/', '$1_$2', $text);
        $text = strtolower($text);
        $text = trim($text, '_');
        return preg_replace('/_+/', '_', $text);
    }

    /**
     * Transform text to kebab-case
     * 
     * @param string $text Input text to transform
     * @return string Transformed text in kebab-case
     */
    public function toKebabCase(string $text): string
    {
        $text = preg_replace('/[^a-zA-Z0-9]+/', '-', $text);
        $text = preg_replace('/([a-z])([A-Z])/', '$1-$2', $text);
        $text = strtolower($text);
        $text = trim($text, '-');
        return preg_replace('/-+/', '-', $text);
    }

    /**
     * Transform text to PascalCase
     * 
     * @param string $text Input text to transform
     * @return string Transformed text in PascalCase
     */
    public function toPascalCase(string $text): string
    {
        $text = preg_replace('/[^a-zA-Z0-9]+/', ' ', $text);
        $text = trim($text);
        $text = ucwords($text);
        return str_replace(' ', '', $text);
    }

    /**
     * Transform text to CONSTANT_CASE
     * 
     * @param string $text Input text to transform
     * @return string Transformed text in CONSTANT_CASE
     */
    public function toConstantCase(string $text): string
    {
        return strtoupper($this->toSnakeCase($text));
    }

    /**
     * Transform text to dot.case
     * 
     * @param string $text Input text to transform
     * @return string Transformed text in dot.case
     */
    public function toDotCase(string $text): string
    {
        $text = preg_replace('/[^a-zA-Z0-9]+/', '.', $text);
        $text = preg_replace('/([a-z])([A-Z])/', '$1.$2', $text);
        $text = strtolower($text);
        $text = trim($text, '.');
        return preg_replace('/\.+/', '.', $text);
    }

    /**
     * Transform text to path/case
     * 
     * @param string $text Input text to transform
     * @return string Transformed text in path/case
     */
    public function toPathCase(string $text): string
    {
        $text = preg_replace('/[^a-zA-Z0-9]+/', '/', $text);
        $text = preg_replace('/([a-z])([A-Z])/', '$1/$2', $text);
        $text = strtolower($text);
        $text = trim($text, '/');
        return preg_replace('/\/+/', '/', $text);
    }

    /**
     * Transform text to Header-Case (HTTP header style)
     * 
     * @param string $text Input text to transform
     * @return string Transformed text in Header-Case
     */
    public function toHeaderCase(string $text): string
    {
        $text = preg_replace('/[^a-zA-Z0-9]+/', '-', $text);
        $text = trim($text, '-');
        $words = explode('-', $text);
        $words = array_map('ucfirst', array_map('strtolower', $words));
        return implode('-', $words);
    }

    /**
     * Transform text to Train-Case
     * 
     * @param string $text Input text to transform
     * @return string Transformed text in Train-Case
     */
    public function toTrainCase(string $text): string
    {
        return $this->toHeaderCase($text);
    }

    /**
     * Transform text to slug-case (URL friendly)
     * 
     * @param string $text Input text to transform
     * @return string Transformed text in slug-case
     */
    public function toSlugCase(string $text): string
    {
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        $text = preg_replace('/[^a-zA-Z0-9]+/', '-', $text);
        $text = strtolower($text);
        $text = trim($text, '-');
        return preg_replace('/-+/', '-', $text);
    }

    /**
     * Transform text to sPoNgEbOb cAsE (mocking case)
     * 
     * @param string $text Input text to transform
     * @return string Transformed text in sPoNgEbOb cAsE
     */
    public function toSpongebobCase(string $text): string
    {
        $result = '';
        $chars = mb_str_split($text);
        $upper = false;
        
        foreach ($chars as $char) {
            if (preg_match('/\p{L}/u', $char)) {
                $result .= $upper ? mb_strtoupper($char) : mb_strtolower($char);
                $upper = !$upper;
            } else {
                $result .= $char;
            }
        }
        
        return $result;
    }

    /**
     * Transform text to Wide Text (fullwidth Unicode)
     * 
     * @param string $text Input text to transform
     * @return string Transformed text in Wide Text
     */
    public function toWideText(string $text): string
    {
        $result = '';
        $chars = mb_str_split($text);
        
        foreach ($chars as $char) {
            $code = mb_ord($char);
            
            if ($code >= 33 && $code <= 126) {
                // Convert ASCII to fullwidth
                $result .= mb_chr($code + 0xFEE0);
            } elseif ($code == 32) {
                // Convert space to ideographic space
                $result .= mb_chr(0x3000);
            } else {
                $result .= $char;
            }
        }
        
        return $result;
    }

    /**
     * Transform text to InVeRsE cAsE (swap case)
     * 
     * @param string $text Input text to transform
     * @return string Transformed text with swapped case
     */
    public function toInverseCase(string $text): string
    {
        $result = '';
        $chars = mb_str_split($text);
        
        foreach ($chars as $char) {
            if (mb_strtolower($char) === $char) {
                $result .= mb_strtoupper($char);
            } else {
                $result .= mb_strtolower($char);
            }
        }
        
        return $result;
    }

    /**
     * Transform text to small caps (Unicode small capitals)
     * 
     * @param string $text Input text to transform
     * @return string Transformed text in small caps
     */
    public function toSmallCaps(string $text): string
    {
        $smallCapsMap = [
            'a' => 'ᴀ', 'b' => 'ʙ', 'c' => 'ᴄ', 'd' => 'ᴅ', 'e' => 'ᴇ',
            'f' => 'ꜰ', 'g' => 'ɢ', 'h' => 'ʜ', 'i' => 'ɪ', 'j' => 'ᴊ',
            'k' => 'ᴋ', 'l' => 'ʟ', 'm' => 'ᴍ', 'n' => 'ɴ', 'o' => 'ᴏ',
            'p' => 'ᴘ', 'q' => 'ǫ', 'r' => 'ʀ', 's' => 'ꜱ', 't' => 'ᴛ',
            'u' => 'ᴜ', 'v' => 'ᴠ', 'w' => 'ᴡ', 'x' => 'x', 'y' => 'ʏ',
            'z' => 'ᴢ'
        ];
        
        $result = '';
        $chars = mb_str_split(mb_strtolower($text));
        
        foreach ($chars as $char) {
            $result .= $smallCapsMap[$char] ?? $char;
        }
        
        return $result;
    }

    /**
     * Reverse the text
     * 
     * @param string $text Input text to transform
     * @return string Reversed text
     */
    public function reverseText(string $text): string
    {
        $chars = mb_str_split($text);
        return implode('', array_reverse($chars));
    }

    /**
     * Remove all whitespace
     * 
     * @param string $text Input text to transform
     * @return string Text with all whitespace removed
     */
    public function removeWhitespace(string $text): string
    {
        return preg_replace('/\s+/', '', $text);
    }

    /**
     * Remove extra spaces (normalize whitespace)
     * 
     * @param string $text Input text to transform
     * @return string Text with normalized whitespace
     */
    public function removeExtraSpaces(string $text): string
    {
        $text = preg_replace('/\s+/', ' ', $text);
        return trim($text);
    }

    /**
     * Add spaces between words (for concatenated text)
     * 
     * @param string $text Input text to transform
     * @return string Text with spaces added between words
     */
    public function addSpaces(string $text): string
    {
        // Add space before capitals
        $text = preg_replace('/([a-z])([A-Z])/', '$1 $2', $text);
        // Add space before numbers following letters
        $text = preg_replace('/([a-zA-Z])([0-9])/', '$1 $2', $text);
        // Add space after numbers followed by letters
        $text = preg_replace('/([0-9])([a-zA-Z])/', '$1 $2', $text);
        // Normalize multiple spaces
        return $this->removeExtraSpaces($text);
    }

    /**
     * Convert spaces to underscores
     * 
     * @param string $text Input text to transform
     * @return string Text with spaces replaced by underscores
     */
    public function spacesToUnderscores(string $text): string
    {
        return str_replace(' ', '_', $text);
    }

    /**
     * Convert underscores to spaces
     * 
     * @param string $text Input text to transform
     * @return string Text with underscores replaced by spaces
     */
    public function underscoresToSpaces(string $text): string
    {
        return str_replace('_', ' ', $text);
    }

    /**
     * Transform text to binary representation
     * 
     * @param string $text Input text to transform
     * @return string Binary representation of text
     */
    public function toBinary(string $text): string
    {
        $result = [];
        $chars = mb_str_split($text);
        
        foreach ($chars as $char) {
            $result[] = sprintf('%08b', mb_ord($char));
        }
        
        return implode(' ', $result);
    }

    /**
     * Transform text to Morse code
     * 
     * @param string $text Input text to transform
     * @return string Morse code representation
     */
    public function toMorseCode(string $text): string
    {
        $morseCode = [
            'A' => '.-', 'B' => '-...', 'C' => '-.-.', 'D' => '-..', 'E' => '.',
            'F' => '..-.', 'G' => '--.', 'H' => '....', 'I' => '..', 'J' => '.---',
            'K' => '-.-', 'L' => '.-..', 'M' => '--', 'N' => '-.', 'O' => '---',
            'P' => '.--.', 'Q' => '--.-', 'R' => '.-.', 'S' => '...', 'T' => '-',
            'U' => '..-', 'V' => '...-', 'W' => '.--', 'X' => '-..-', 'Y' => '-.--',
            'Z' => '--..', '0' => '-----', '1' => '.----', '2' => '..---',
            '3' => '...--', '4' => '....-', '5' => '.....', '6' => '-....',
            '7' => '--...', '8' => '---..', '9' => '----.'
        ];
        
        $result = [];
        $text = strtoupper($text);
        $chars = str_split($text);
        
        foreach ($chars as $char) {
            if (isset($morseCode[$char])) {
                $result[] = $morseCode[$char];
            } elseif ($char === ' ') {
                $result[] = '/';
            }
        }
        
        return implode(' ', $result);
    }

    /**
     * Transform text to Zalgo text (creepy text with combining characters)
     * 
     * @param string $text Input text to transform
     * @param int $intensity Intensity of zalgo effect (1-10)
     * @return string Zalgo text
     */
    public function toZalgoText(string $text, int $intensity = 5): string
    {
        $textEffectsService = app(TextEffectsService::class);
        return $textEffectsService->toZalgo($text, $intensity);
    }

    /**
     * Capitalize first letter only (rest lowercase)
     * 
     * @param string $text Input text to transform
     * @return string Text with only first letter capitalized
     */
    public function capitalizeFirstLetterOnly(string $text): string
    {
        if (mb_strlen($text) === 0) {
            return $text;
        }
        
        $firstChar = mb_strtoupper(mb_substr($text, 0, 1));
        $rest = mb_strtolower(mb_substr($text, 1));
        
        return $firstChar . $rest;
    }

    /**
     * Fix prepositions in title case text
     * 
     * @param string $text Input text to transform
     * @return string Text with prepositions in lowercase
     */
    public function fixPrepositions(string $text): string
    {
        $prepositions = [
            'a', 'an', 'and', 'as', 'at', 'but', 'by', 'for', 'from',
            'in', 'into', 'nor', 'of', 'on', 'or', 'per', 'the', 'to',
            'with', 'via', 'vs', 'versus'
        ];
        
        $words = explode(' ', $text);
        $result = [];
        
        foreach ($words as $index => $word) {
            $lowerWord = strtolower($word);
            if ($index > 0 && in_array($lowerWord, $prepositions)) {
                $result[] = $lowerWord;
            } else {
                $result[] = $word;
            }
        }
        
        return implode(' ', $result);
    }

    /**
     * Main transformation dispatcher method
     * Routes transformation requests to appropriate methods
     * 
     * @param string $text Input text to transform
     * @param string $transformationType Type of transformation to apply
     * @return string Transformed text
     * @throws \InvalidArgumentException If transformation type is not supported
     */
    public function transform(string $text, string $transformationType, array $preservationConfig = []): string
    {
        $methodMap = [
            // Standard cases
            'lowercase' => 'toLowerCase',
            'uppercase' => 'toUpperCase',
            'titleCase' => 'toTitleCase',
            'sentenceCase' => 'toSentenceCase',
            'capitalizeFirst' => 'capitalizeFirstLetterOnly',
            'capitalizeWords' => 'toFirstLetter',
            'alternatingCase' => 'toAlternatingCase',
            'randomCase' => 'toRandomCase',
            
            // Developer cases
            'camelCase' => 'toCamelCase',
            'pascalCase' => 'toPascalCase',
            'snakeCase' => 'toSnakeCase',
            'constantCase' => 'toConstantCase',
            'kebabCase' => 'toKebabCase',
            'dotCase' => 'toDotCase',
            'pathCase' => 'toPathCase',
            'headerCase' => 'toHeaderCase',
            'trainCase' => 'toTrainCase',
            'slugCase' => 'toSlugCase',
            
            // Creative cases
            'spongebobCase' => 'toSpongebobCase',
            'inverseCase' => 'toInverseCase',
            'reverseText' => 'reverseText',
            'wideText' => 'toWideText',
            'smallCaps' => 'toSmallCaps',
            'zalgoText' => 'toZalgoText',
            'morseCode' => 'toMorseCode',
            'binary' => 'toBinary',
            
            // Text Effects
            'bold-text' => 'toBoldText',
            'italic-text' => 'toItalicText',
            'strikethrough-text' => 'toStrikethroughText',
            'underline-text' => 'toUnderlineText',
            'superscript' => 'toSuperscript',
            'subscript' => 'toSubscript',
            'upside-down' => 'toUpsideDown',
            'mirror-text' => 'toMirrorText',
            'zalgo-text' => 'toZalgoText',
            'cursed-text' => 'toCursedText',
            'invisible-text' => 'toInvisibleText',
            'wide-text' => 'toWideText',
            
            // Generators
            'password-generator' => 'generatePassword',
            'uuid-generator' => 'generateUUID',
            'random-number' => 'generateRandomNumber',
            'random-letter' => 'generateRandomLetter',
            'random-date' => 'generateRandomDate',
            'random-ip' => 'generateRandomIP',
            'lorem-ipsum' => 'generateLoremIpsum',
            'username-generator' => 'generateUsername',
            'email-generator' => 'generateEmail',
            'hex-color' => 'generateHexColor',
            'phone-number' => 'generatePhoneNumber',
            'random-choice' => 'generateRandomChoice',
            
            // Encoding cases
            'base64Encode' => 'base64Encode',
            'base64Decode' => 'base64Decode',
            'urlEncode' => 'urlEncode',
            'urlDecode' => 'urlDecode',
            'htmlEncode' => 'htmlEncode',
            'htmlDecode' => 'htmlDecode',
            'rot13' => 'rot13',
            
            // Whitespace operations
            'removeAllSpaces' => 'removeWhitespace',
            'removeExtraSpaces' => 'removeExtraSpaces',
            'trimWhitespace' => 'trimWhitespace',
            'addSpaces' => 'addSpaces',
            'spacesToUnderscores' => 'spacesToUnderscores',
            'underscoresToSpaces' => 'underscoresToSpaces',
            
            // Smart quotes
            'smartQuotes' => 'toSmartQuotes',
            'fixPrepositions' => 'fixPrepositions'
        ];
        
        if (!isset($methodMap[$transformationType])) {
            throw new \InvalidArgumentException("Unsupported transformation type: {$transformationType}");
        }
        
        $method = $methodMap[$transformationType];
        
        // Handle special methods that need implementation
        switch ($method) {
            case 'base64Encode':
                return base64_encode($text);
            case 'base64Decode':
                return base64_decode($text) ?: $text;
            case 'urlEncode':
                return rawurlencode($text);
            case 'urlDecode':
                return urldecode($text);
            case 'htmlEncode':
                return htmlspecialchars($text, ENT_QUOTES | ENT_HTML5);
            case 'htmlDecode':
                return html_entity_decode($text, ENT_QUOTES | ENT_HTML5);
            case 'rot13':
                return str_rot13($text);
            case 'trimWhitespace':
                return trim($text);
            default:
                if (method_exists($this, $method)) {
                    return $this->$method($text);
                }
                throw new \InvalidArgumentException("Method not found: {$method}");
        }
    }

    /**
     * Convert straight quotes to smart quotes
     * 
     * @param string $text Input text to transform
     * @return string Text with smart quotes
     */
    public function toSmartQuotes(string $text): string
    {
        // Replace straight double quotes
        $text = preg_replace('/(\s|^)"/', '$1"', $text); // Opening
        $text = preg_replace('/"(\s|$)/', '"$1', $text); // Closing
        
        // Replace straight single quotes/apostrophes
        $text = preg_replace("/(\s|^)'/", "$1'", $text); // Opening
        $text = preg_replace("/'(\s|$)/", "'$1", $text); // Closing
        $text = str_replace("'", "'", $text); // Apostrophes
        
        return $text;
    }

    /**
     * Convert text to bold using Unicode characters
     * 
     * @param string $text Input text to transform
     * @return string Bold text using Unicode
     */
    public function toBoldText(string $text): string
    {
        $textEffectsService = app(TextEffectsService::class);
        return $textEffectsService->toBold($text);
    }

    /**
     * Convert text to italic using Unicode characters
     * 
     * @param string $text Input text to transform
     * @return string Italic text using Unicode
     */
    public function toItalicText(string $text): string
    {
        $textEffectsService = app(TextEffectsService::class);
        return $textEffectsService->toItalic($text);
    }

    /**
     * Add strikethrough to text using Unicode
     * 
     * @param string $text Input text to transform
     * @return string Strikethrough text
     */
    public function toStrikethroughText(string $text): string
    {
        $textEffectsService = app(TextEffectsService::class);
        return $textEffectsService->toStrikethrough($text);
    }

    /**
     * Add underline to text using Unicode
     * 
     * @param string $text Input text to transform
     * @return string Underlined text
     */
    public function toUnderlineText(string $text): string
    {
        $textEffectsService = app(TextEffectsService::class);
        return $textEffectsService->toUnderline($text);
    }

    /**
     * Convert text to superscript
     * 
     * @param string $text Input text to transform
     * @return string Superscript text
     */
    public function toSuperscript(string $text): string
    {
        $textEffectsService = app(TextEffectsService::class);
        return $textEffectsService->toSuperscript($text);
    }

    /**
     * Convert text to subscript
     * 
     * @param string $text Input text to transform
     * @return string Subscript text
     */
    public function toSubscript(string $text): string
    {
        $textEffectsService = app(TextEffectsService::class);
        return $textEffectsService->toSubscript($text);
    }

    /**
     * Convert text to upside down
     * 
     * @param string $text Input text to transform
     * @return string Upside down text
     */
    public function toUpsideDown(string $text): string
    {
        $textEffectsService = app(TextEffectsService::class);
        return $textEffectsService->toUpsideDown($text);
    }

    /**
     * Convert text to mirror/reverse
     * 
     * @param string $text Input text to transform
     * @return string Mirrored text
     */
    public function toMirrorText(string $text): string
    {
        $textEffectsService = app(TextEffectsService::class);
        return $textEffectsService->toMirror($text);
    }


    /**
     * Convert text to cursed text
     * 
     * @param string $text Input text to transform
     * @return string Cursed text
     */
    public function toCursedText(string $text): string
    {
        $textEffectsService = app(TextEffectsService::class);
        return $textEffectsService->toCursed($text);
    }

    /**
     * Convert text to invisible text
     * 
     * @param string $text Input text to transform
     * @return string Invisible text
     */
    public function toInvisibleText(string $text): string
    {
        $textEffectsService = app(TextEffectsService::class);
        return $textEffectsService->toInvisible($text);
    }

    /**
     * Generate strong password
     * 
     * @param string $text Ignored, generates new password
     * @return string Generated password
     */
    public function generatePassword(string $text): string
    {
        $generatorService = app(GeneratorService::class);
        return $generatorService->generatePassword();
    }

    /**
     * Generate UUID
     * 
     * @param string $text Ignored, generates new UUID
     * @return string Generated UUID
     */
    public function generateUUID(string $text): string
    {
        $generatorService = app(GeneratorService::class);
        return $generatorService->generateUUID();
    }

    /**
     * Generate random number
     * 
     * @param string $text Used to parse min/max if provided
     * @return string Generated random number
     */
    public function generateRandomNumber(string $text): string
    {
        $generatorService = app(GeneratorService::class);
        // Parse text for range if provided (e.g., "1-100")
        if (preg_match('/(\d+)\s*-\s*(\d+)/', $text, $matches)) {
            return (string) $generatorService->generateNumber((int)$matches[1], (int)$matches[2]);
        }
        return (string) $generatorService->generateNumber(1, 100);
    }

    /**
     * Generate random letters
     * 
     * @param string $text Used to parse count if provided
     * @return string Generated random letters
     */
    public function generateRandomLetter(string $text): string
    {
        $generatorService = app(GeneratorService::class);
        // Parse text for count if provided
        if (preg_match('/\d+/', $text, $matches)) {
            return $generatorService->generateLetters((int)$matches[0]);
        }
        return $generatorService->generateLetters(5);
    }

    /**
     * Generate random date
     * 
     * @param string $text Ignored, generates random date
     * @return string Generated random date
     */
    public function generateRandomDate(string $text): string
    {
        $generatorService = app(GeneratorService::class);
        return $generatorService->generateDate();
    }

    /**
     * Generate random IP address
     * 
     * @param string $text Used to determine v4/v6
     * @return string Generated IP address
     */
    public function generateRandomIP(string $text): string
    {
        $generatorService = app(GeneratorService::class);
        $version = strpos(strtolower($text), 'v6') !== false ? 'v6' : 'v4';
        return $generatorService->generateIPAddress($version);
    }

    /**
     * Generate lorem ipsum
     * 
     * @param string $text Used to parse word count
     * @return string Generated lorem ipsum
     */
    public function generateLoremIpsum(string $text): string
    {
        $generatorService = app(GeneratorService::class);
        // Parse text for word count if provided
        if (preg_match('/\d+/', $text, $matches)) {
            return $generatorService->generateLoremIpsum((int)$matches[0]);
        }
        return $generatorService->generateLoremIpsum(50);
    }

    /**
     * Generate username
     * 
     * @param string $text Ignored, generates random username
     * @return string Generated username
     */
    public function generateUsername(string $text): string
    {
        $generatorService = app(GeneratorService::class);
        return $generatorService->generateUsername();
    }

    /**
     * Generate email
     * 
     * @param string $text Can contain domain
     * @return string Generated email
     */
    public function generateEmail(string $text): string
    {
        $generatorService = app(GeneratorService::class);
        // Check if text contains a domain
        if (filter_var($text, FILTER_VALIDATE_DOMAIN)) {
            return $generatorService->generateEmail($text);
        }
        return $generatorService->generateEmail();
    }

    /**
     * Generate hex color
     * 
     * @param string $text Ignored, generates random hex color
     * @return string Generated hex color
     */
    public function generateHexColor(string $text): string
    {
        $generatorService = app(GeneratorService::class);
        return $generatorService->generateHexColor();
    }

    /**
     * Generate phone number
     * 
     * @param string $text Can specify format (US, UK, International)
     * @return string Generated phone number
     */
    public function generatePhoneNumber(string $text): string
    {
        $generatorService = app(GeneratorService::class);
        $format = 'US';
        if (stripos($text, 'uk') !== false) $format = 'UK';
        elseif (stripos($text, 'international') !== false) $format = 'International';
        return $generatorService->generatePhoneNumber($format);
    }

    /**
     * Generate random choice from list
     * 
     * @param string $text List separated by newlines or commas
     * @return string Random choice from list
     */
    public function generateRandomChoice(string $text): string
    {
        $generatorService = app(GeneratorService::class);
        // Parse list from text
        $items = preg_split('/[\n,]+/', $text);
        $items = array_map('trim', $items);
        $items = array_filter($items);
        if (empty($items)) {
            return 'Please provide a list of items separated by commas or newlines';
        }
        return $generatorService->generateChoice($items);
    }
}
