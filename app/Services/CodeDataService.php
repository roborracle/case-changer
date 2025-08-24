<?php

namespace App\Services;

/**
 * Code & Data Transformation Service
 * Handles encoding, decoding, formatting, and data conversions
 */
class CodeDataService
{
    /**
     * Convert text to binary
     */
    public function toBinary(string $text): string
    {
        $binary = [];
        for ($i = 0; $i < mb_strlen($text); $i++) {
            $char = mb_substr($text, $i, 1);
            $binary[] = sprintf("%08b", mb_ord($char));
        }
        return implode(' ', $binary);
    }

    /**
     * Convert binary to text
     */
    public function fromBinary(string $binary): string
    {
        $binary = preg_replace('/[^01]/', '', $binary);
        $text = '';
        
        for ($i = 0; $i < strlen($binary); $i += 8) {
            $byte = substr($binary, $i, 8);
            if (strlen($byte) == 8) {
                $text .= chr(bindec($byte));
            }
        }
        return $text;
    }

    /**
     * Convert text to hexadecimal
     */
    public function toHex(string $text): string
    {
        return bin2hex($text);
    }

    /**
     * Convert hexadecimal to text
     */
    public function fromHex(string $hex): string
    {
        $hex = preg_replace('/[^0-9a-fA-F]/', '', $hex);
        return hex2bin($hex) ?: '';
    }

    /**
     * Convert text to Morse code
     */
    public function toMorse(string $text): string
    {
        $morse = [
            'A' => '.-', 'B' => '-...', 'C' => '-.-.', 'D' => '-..', 'E' => '.', 'F' => '..-.', 
            'G' => '--.', 'H' => '....', 'I' => '..', 'J' => '.---', 'K' => '-.-', 'L' => '.-..', 
            'M' => '--', 'N' => '-.', 'O' => '---', 'P' => '.--.', 'Q' => '--.-', 'R' => '.-.', 
            'S' => '...', 'T' => '-', 'U' => '..-', 'V' => '...-', 'W' => '.--', 'X' => '-..-', 
            'Y' => '-.--', 'Z' => '--..', 
            '0' => '-----', '1' => '.----', '2' => '..---', '3' => '...--', '4' => '....-', 
            '5' => '.....', '6' => '-....', '7' => '--...', '8' => '---..', '9' => '----.',
            '.' => '.-.-.-', ',' => '--..--', '?' => '..--..', '\'' => '.----.', '!' => '-.-.--',
            '/' => '-..-.', '(' => '-.--.', ')' => '-.--.-', '&' => '.-...', ':' => '---...',
            ';' => '-.-.-.', '=' => '-...-', '+' => '.-.-.', '-' => '-....-', '_' => '..--.-',
            '"' => '.-..-.', '$' => '...-..-', '@' => '.--.-.', ' ' => '/'
        ];
        
        $text = strtoupper($text);
        $result = [];
        
        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            if (isset($morse[$char])) {
                $result[] = $morse[$char];
            }
        }
        
        return implode(' ', $result);
    }

    /**
     * Caesar cipher encryption/decryption
     */
    public function caesarCipher(string $text, int $shift = 3): string
    {
        $result = '';
        $shift = $shift % 26;
        
        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            
            if (ctype_upper($char)) {
                $result .= chr((ord($char) - 65 + $shift) % 26 + 65);
            } elseif (ctype_lower($char)) {
                $result .= chr((ord($char) - 97 + $shift) % 26 + 97);
            } else {
                $result .= $char;
            }
        }
        
        return $result;
    }

    /**
     * Generate MD5 hash
     */
    public function toMD5(string $text): string
    {
        return md5($text);
    }

    /**
     * Generate SHA256 hash
     */
    public function toSHA256(string $text): string
    {
        return hash('sha256', $text);
    }

    /**
     * Convert to slug format
     */
    public function toSlug(string $text): string
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        
        if (empty($text)) {
            return 'n-a';
        }
        
        return $text;
    }

    /**
     * Format JSON with pretty print
     */
    public function formatJSON(string $json): string
    {
        $decoded = json_decode($json);
        if (json_last_error() === JSON_ERROR_NONE) {
            return json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
        return $json;
    }

    /**
     * Minify JSON
     */
    public function minifyJSON(string $json): string
    {
        $decoded = json_decode($json);
        if (json_last_error() === JSON_ERROR_NONE) {
            return json_encode($decoded, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
        return $json;
    }

    /**
     * Convert CSV to JSON
     */
    public function csvToJSON(string $csv): string
    {
        $lines = explode("\n", trim($csv));
        $headers = str_getcsv(array_shift($lines));
        $data = [];
        
        foreach ($lines as $line) {
            if (trim($line)) {
                $row = str_getcsv($line);
                $data[] = array_combine($headers, $row);
            }
        }
        
        return json_encode($data, JSON_PRETTY_PRINT);
    }

    /**
     * Format CSS
     */
    public function formatCSS(string $css): string
    {
        // Basic CSS formatting
        $css = preg_replace('/\s*{\s*/', ' {' . "\n  ", $css);
        $css = preg_replace('/;\s*/', ';' . "\n  ", $css);
        $css = preg_replace('/\s*}\s*/', "\n}\n\n", $css);
        $css = preg_replace('/  }/', '}', $css);
        
        return trim($css);
    }

    /**
     * Minify CSS
     */
    public function minifyCSS(string $css): string
    {
        // Remove comments
        $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
        // Remove unnecessary whitespace
        $css = preg_replace('/\s+/', ' ', $css);
        $css = preg_replace('/\s*([{}:;,])\s*/', '$1', $css);
        
        return trim($css);
    }

    /**
     * Format HTML
     */
    public function formatHTML(string $html): string
    {
        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        
        // Suppress errors for invalid HTML
        libxml_use_internal_errors(true);
        $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        
        return $dom->saveHTML();
    }

    /**
     * Minify HTML
     */
    public function minifyHTML(string $html): string
    {
        // Remove comments
        $html = preg_replace('/<!--(?!<!)[^\[>].*?-->/', '', $html);
        // Remove whitespace
        $html = preg_replace('/\s+/', ' ', $html);
        $html = preg_replace('/>\s+</', '><', $html);
        
        return trim($html);
    }

    /**
     * Format JavaScript
     */
    public function formatJavaScript(string $js): string
    {
        // Basic JS formatting
        $js = preg_replace('/\s*{\s*/', ' {\n  ', $js);
        $js = preg_replace('/;\s*/', ';\n  ', $js);
        $js = preg_replace('/\s*}\s*/', '\n}', $js);
        
        return trim($js);
    }

    /**
     * Convert to UTF-8
     */
    public function toUTF8(string $text, string $fromEncoding = 'auto'): string
    {
        if ($fromEncoding === 'auto') {
            $fromEncoding = mb_detect_encoding($text, 'UTF-8, ISO-8859-1, Windows-1252', true);
        }
        
        return mb_convert_encoding($text, 'UTF-8', $fromEncoding);
    }

    /**
     * Build UTM parameters
     */
    public function buildUTM(string $url, array $params): string
    {
        $utm = [];
        $validParams = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'];
        
        foreach ($params as $key => $value) {
            if (in_array($key, $validParams) && !empty($value)) {
                $utm[] = $key . '=' . urlencode($value);
            }
        }
        
        if (empty($utm)) {
            return $url;
        }
        
        $separator = strpos($url, '?') === false ? '?' : '&';
        return $url . $separator . implode('&', $utm);
    }

    /**
     * Format XML
     */
    public function formatXML(string $xml): string
    {
        $dom = new \DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        
        // Suppress errors for invalid XML
        libxml_use_internal_errors(true);
        $dom->loadXML($xml);
        libxml_clear_errors();
        
        return $dom->saveXML();
    }

    /**
     * Format YAML
     */
    public function formatYAML(string $yaml): string
    {
        // Basic YAML formatting
        $lines = explode("\n", $yaml);
        $formatted = [];
        $indent = 0;
        
        foreach ($lines as $line) {
            $trimmed = trim($line);
            if (empty($trimmed)) continue;
            
            // Decrease indent for list items
            if (strpos($trimmed, '-') === 0) {
                $indent = max(0, $indent - 2);
            }
            
            $formatted[] = str_repeat(' ', $indent) . $trimmed;
            
            // Increase indent after colons
            if (substr($trimmed, -1) === ':' && strpos($trimmed, ': ') === false) {
                $indent += 2;
            }
        }
        
        return implode("\n", $formatted);
    }
}