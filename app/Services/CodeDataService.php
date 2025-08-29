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
        $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
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
        $html = preg_replace('/<!--(?!<!)[^\[>].*?-->/', '', $html);
        $html = preg_replace('/\s+/', ' ', $html);
        $html = preg_replace('/>\s+</', '><', $html);
        
        return trim($html);
    }

    /**
     * Format JavaScript
     */
    public function formatJavaScript(string $js): string
    {
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
        $lines = explode("\n", $yaml);
        $formatted = [];
        $indent = 0;
        
        foreach ($lines as $line) {
            $trimmed = trim($line);
            if (empty($trimmed)) continue;
            
            if (strpos($trimmed, '-') === 0) {
                $indent = max(0, $indent - 2);
            }
            
            $formatted[] = str_repeat(' ', $indent) . $trimmed;
            
            if (substr($trimmed, -1) === ':' && strpos($trimmed, ': ') === false) {
                $indent += 2;
            }
        }
        
        return implode("\n", $formatted);
    }

    /**
     * Format TypeScript code
     */
    public function formatTypeScript(string $ts): string
    {
        $ts = preg_replace('/\s*{\s*/', ' {\n  ', $ts);
        $ts = preg_replace('/;\s*/', ';\n  ', $ts);
        $ts = preg_replace('/\s*}\s*/', '\n}', $ts);
        
        return trim($ts);
    }

    /**
     * Format GraphQL schema/query
     */
    public function formatGraphQL(string $graphql): string
    {
        $graphql = preg_replace('/\s*{\s*/', ' {\n  ', $graphql);
        $graphql = preg_replace('/,\s*/', ',\n  ', $graphql);
        $graphql = preg_replace('/\s*}\s*/', '\n}\n', $graphql);
        
        return trim($graphql);
    }

    /**
     * Format SCSS/Sass
     */
    public function formatSCSS(string $scss): string
    {
        $scss = preg_replace('/\s*{\s*/', ' {\n  ', $scss);
        $scss = preg_replace('/;\s*/', ';\n  ', $scss);
        $scss = preg_replace('/\s*}\s*/', '\n}\n\n', $scss);
        $scss = preg_replace('/  }/', '}', $scss);
        
        return trim($scss);
    }

    /**
     * Generate MD5 hash with salt option
     */
    public function generateMD5WithSalt(string $text, string $salt = ''): string
    {
        return md5($salt . $text);
    }

    /**
     * Generate SHA1 hash
     */
    public function toSHA1(string $text): string
    {
        return sha1($text);
    }

    /**
     * Generate SHA512 hash
     */
    public function toSHA512(string $text): string
    {
        return hash('sha512', $text);
    }

    /**
     * JSON stringify with escape handling
     */
    public function jsonStringify(string $text): string
    {
        return json_encode($text, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Format Markdown
     */
    public function formatMarkdown(string $markdown): string
    {
        $lines = explode("\n", $markdown);
        $formatted = [];
        
        foreach ($lines as $line) {
            $trimmed = trim($line);
            
            if (preg_match('/^#+/', $trimmed)) {
                $formatted[] = $trimmed;
                $formatted[] = '';
            }
            elseif (preg_match('/^[-*+]\s/', $trimmed) || preg_match('/^\d+\.\s/', $trimmed)) {
                $formatted[] = $trimmed;
            }
            elseif (empty($trimmed)) {
                $formatted[] = '';
            }
            else {
                $formatted[] = $trimmed;
            }
        }
        
        return implode("\n", $formatted);
    }

    /**
     * Test regex pattern
     */
    public function testRegex(string $pattern, string $text, array $flags = []): array
    {
        $matches = [];
        $result = [
            'valid' => true,
            'matches' => [],
            'count' => 0,
            'error' => null
        ];
        
        try {
            if (!preg_match('/^[\/#~`].*[\/#~`][gimsx]*$/', $pattern)) {
                $pattern = '/' . $pattern . '/';
            }
            
            $count = preg_match_all($pattern, $text, $matches);
            
            if ($count === false) {
                $result['valid'] = false;
                $result['error'] = 'Invalid regex pattern';
            } else {
                $result['count'] = $count;
                $result['matches'] = $matches[0] ?? [];
            }
        } catch (Exception $e) {
            $result['valid'] = false;
            $result['error'] = $e->getMessage();
        }
        
        return $result;
    }

    /**
     * Sort numbers from text
     */
    public function sortNumbers(string $text, bool $ascending = true): string
    {
        preg_match_all('/\d+(?:\.\d+)?/', $text, $matches);
        $numbers = array_map('floatval', $matches[0]);
        
        if ($ascending) {
            sort($numbers);
        } else {
            rsort($numbers);
        }
        
        return implode('\n', $numbers);
    }

    /**
     * Encode UTF-8
     */
    public function encodeUTF8(string $text): string
    {
        return mb_convert_encoding($text, 'UTF-8', 'auto');
    }

    /**
     * Decode UTF-8 to entities
     */
    public function decodeUTF8ToEntities(string $text): string
    {
        return mb_convert_encoding($text, 'HTML-ENTITIES', 'UTF-8');
    }

    /**
     * Generate secure hash
     */
    public function generateSecureHash(string $text, string $algorithm = 'sha256'): string
    {
        $supportedAlgos = ['md5', 'sha1', 'sha256', 'sha512'];
        
        if (!in_array($algorithm, $supportedAlgos)) {
            $algorithm = 'sha256';
        }
        
        return hash($algorithm, $text);
    }

    /**
     * Minify JavaScript
     */
    public function minifyJavaScript(string $js): string
    {
        $js = str_replace(['; ', ' {', '{ ', '} ', ' }', ', '], [';', '{', '{', '}', '}', ','], $js);
        
        return trim($js);
    }

    /**
     * Convert JSON to other formats
     */
    public function convertJSONToFormat(string $json, string $format = 'yaml'): string
    {
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return 'Invalid JSON';
        }
        
        switch (strtolower($format)) {
            case 'yaml':
                return $this->arrayToYAML($data);
            case 'xml':
                return $this->arrayToXML($data);
            case 'csv':
                return $this->arrayToCSV($data);
            default:
                return json_encode($data, JSON_PRETTY_PRINT);
        }
    }

    /**
     * Convert array to YAML format
     */
    private function arrayToYAML(array $data, int $indent = 0): string
    {
        $yaml = '';
        $spaces = str_repeat('  ', $indent);
        
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $yaml .= $spaces . $key . ":\n";
                $yaml .= $this->arrayToYAML($value, $indent + 1);
            } else {
                $yaml .= $spaces . $key . ': ' . $value . "\n";
            }
        }
        
        return $yaml;
    }

    /**
     * Convert array to XML format
     */
    private function arrayToXML(array $data, string $root = 'root'): string
    {
        $xml = "<?xml version='1.0' encoding='UTF-8'?>\n";
        $xml .= "<$root>\n";
        $xml .= $this->arrayToXMLRecursive($data, 1);
        $xml .= "</$root>";
        
        return $xml;
    }

    /**
     * Recursive helper for array to XML conversion
     */
    private function arrayToXMLRecursive(array $data, int $indent = 0): string
    {
        $xml = '';
        $spaces = str_repeat('  ', $indent);
        
        foreach ($data as $key => $value) {
            $key = is_numeric($key) ? 'item' : $key;
            
            if (is_array($value)) {
                $xml .= "$spaces<$key>\n";
                $xml .= $this->arrayToXMLRecursive($value, $indent + 1);
                $xml .= "$spaces</$key>\n";
            } else {
                $xml .= "$spaces<$key>" . htmlspecialchars($value) . "</$key>\n";
            }
        }
        
        return $xml;
    }

    /**
     * Convert array to CSV format
     */
    private function arrayToCSV(array $data): string
    {
        if (empty($data)) {
            return '';
        }
        
        $csv = '';
        
        if (is_array($data[0])) {
            $headers = array_keys($data[0]);
            $csv .= implode(',', $headers) . "\n";
            
            foreach ($data as $row) {
                $csv .= implode(',', array_map(function($value) {
                    return '"' . str_replace('"', '""', $value) . '"';
                }, $row)) . "\n";
            }
        } else {
            $csv = implode(',', array_map(function($value) {
                return '"' . str_replace('"', '""', $value) . '"';
            }, $data));
        }
        
        return $csv;
    }
}