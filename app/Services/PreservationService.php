<?php

namespace App\Services;

/**
 * Smart content preservation service for Case Changer Pro
 * 
 * Implements intelligent preservation of special content types during text transformations
 * including URLs, email addresses, brand names, code snippets, and custom patterns.
 * 
 * @package App\Services
 * @since 1.0.0
 */
class PreservationService
{
    /**
     * Common brand names that should be preserved
     * @var array<string>
     */
    private array $brandNames = [
        'iPhone', 'iPad', 'MacBook', 'iOS', 'macOS', 'iPadOS', 'watchOS',
        'GitHub', 'GitLab', 'LinkedIn', 'YouTube', 'WhatsApp', 'TikTok',
        'JavaScript', 'TypeScript', 'PostgreSQL', 'MySQL', 'MongoDB',
        'WordPress', 'WooCommerce', 'MailChimp', 'PayPal', 'eBay',
        'Laravel', 'Vue.js', 'React.js', 'Next.js', 'Node.js',
        'OpenAI', 'ChatGPT', 'DeepMind', 'SpaceX', 'Tesla',
        'Microsoft', 'Google', 'Amazon', 'Facebook', 'Netflix'
    ];

    /**
     * Regular expression patterns for content detection
     * @var array<string, string>
     */
    private array $patterns = [
        'url' => '/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&\/\/=]*)/i',
        'email' => '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/i',
        'hashtag' => '/#[a-zA-Z][a-zA-Z0-9_]*/u',
        'mention' => '/@[a-zA-Z][a-zA-Z0-9_]*/u',
        'code_inline' => '/`[^`]+`/',
        'code_block' => '/```[\s\S]*?```/',
        'math_inline' => '/\$[^\$]+\$/',
        'math_block' => '/\$\$[\s\S]*?\$\$/',
        'ipv4' => '/\b(?:[0-9]{1,3}\.){3}[0-9]{1,3}\b/',
        'ipv6' => '/(?:[a-fA-F0-9]{1,4}:){7}[a-fA-F0-9]{1,4}/',
        'phone' => '/(?:\+?[1-9]\d{0,2}[\s-]?)?\(?\d{1,4}\)?[\s-]?\d{1,4}[\s-]?\d{1,4}/',
        'currency' => '/[$€£¥₹₽¢]\d+(?:\.\d{1,2})?|\d+(?:\.\d{1,2})?[$€£¥₹₽¢]/',
        'percentage' => '/\d+(?:\.\d+)?%/',
        'hex_color' => '/#(?:[0-9a-fA-F]{3}){1,2}\b/',
        'uuid' => '/[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}/',
        'file_path' => '/(?:\/|\\\\)?(?:[a-zA-Z0-9_-]+(?:\/|\\\\))*[a-zA-Z0-9_-]+\.[a-zA-Z]{2,4}/',
        'date_iso' => '/\d{4}-\d{2}-\d{2}(?:T\d{2}:\d{2}:\d{2}(?:\.\d{3})?(?:Z|[+-]\d{2}:\d{2})?)?/'
    ];

    /**
     * Preservation settings
     * @var array<string, bool>
     */
    private array $settings = [
        'preserveUrls' => true,
        'preserveEmails' => true,
        'preserveBrands' => true,
        'preserveHashtags' => true,
        'preserveMentions' => true,
        'preserveCode' => true,
        'preserveMath' => true,
        'preserveNumbers' => false,
        'preserveDates' => true,
        'preserveFilePaths' => true,
        'preserveCurrency' => true,
        'preserveCustom' => false
    ];

    /**
     * Custom patterns added by user
     * @var array<string>
     */
    private array $customPatterns = [];

    /**
     * Preserved content placeholders
     * @var array<string, string>
     */
    private array $preservedContent = [];

    /**
     * Constructor
     * 
     * @param array<string, bool> $settings Optional preservation settings override
     */
    public function __construct(array $settings = [])
    {
        $this->settings = array_merge($this->settings, $settings);
    }

    /**
     * Preserve special content in text before transformation
     * 
     * @param string $text The text to process
     * @return array{0: string, 1: array<string, string>} Tuple of [text with placeholders, preserved items]
     */
    public function preserveContent(string $text): array
    {
        $this->preservedContent = [];
        $placeholderIndex = 0;

        if ($this->settings['preserveCode']) {
            $text = $this->preservePattern($text, 'code_block', $placeholderIndex);
            $text = $this->preservePattern($text, 'code_inline', $placeholderIndex);
        }

        if ($this->settings['preserveMath']) {
            $text = $this->preservePattern($text, 'math_block', $placeholderIndex);
            $text = $this->preservePattern($text, 'math_inline', $placeholderIndex);
        }

        if ($this->settings['preserveUrls']) {
            $text = $this->preservePattern($text, 'url', $placeholderIndex);
        }

        if ($this->settings['preserveEmails']) {
            $text = $this->preservePattern($text, 'email', $placeholderIndex);
        }

        if ($this->settings['preserveBrands']) {
            $text = $this->preserveBrandNames($text, $placeholderIndex);
        }

        if ($this->settings['preserveHashtags']) {
            $text = $this->preservePattern($text, 'hashtag', $placeholderIndex);
        }

        if ($this->settings['preserveMentions']) {
            $text = $this->preservePattern($text, 'mention', $placeholderIndex);
        }

        if ($this->settings['preserveDates']) {
            $text = $this->preservePattern($text, 'date_iso', $placeholderIndex);
        }

        if ($this->settings['preserveFilePaths']) {
            $text = $this->preservePattern($text, 'file_path', $placeholderIndex);
        }

        if ($this->settings['preserveCurrency']) {
            $text = $this->preservePattern($text, 'currency', $placeholderIndex);
            $text = $this->preservePattern($text, 'percentage', $placeholderIndex);
        }

        if ($this->settings['preserveCustom'] && !empty($this->customPatterns)) {
            $text = $this->preserveCustomPatterns($text, $placeholderIndex);
        }

        return [$text, $this->preservedContent];
    }

    /**
     * Restore preserved content after transformation
     * 
     * @param string $text The transformed text with placeholders
     * @param array<string, string> $preservedItems The preserved items to restore
     * @return string Text with preserved content restored
     */
    public function restoreContent(string $text, array $preservedItems): string
    {
        foreach ($preservedItems as $placeholder => $originalContent) {
            $text = str_replace($placeholder, $originalContent, $text);
        }

        return $text;
    }

    /**
     * Apply transformation with smart preservation
     * 
     * @param string $text The text to transform
     * @param callable $transformer The transformation function
     * @return string Transformed text with preserved content intact
     */
    public function transformWithPreservation(string $text, callable $transformer): string
    {
        [$textWithPlaceholders, $preservedItems] = $this->preserveContent($text);
        
        $transformedText = $transformer($textWithPlaceholders);
        
        return $this->restoreContent($transformedText, $preservedItems);
    }

    /**
     * Preserve content matching a specific pattern
     * 
     * @param string $text The text to process
     * @param string $patternName The pattern name from $patterns array
     * @param int &$placeholderIndex Current placeholder index
     * @return string Text with pattern matches replaced by placeholders
     */
    private function preservePattern(string $text, string $patternName, int &$placeholderIndex): string
    {
        if (!isset($this->patterns[$patternName])) {
            return $text;
        }

        return preg_replace_callback(
            $this->patterns[$patternName],
            function ($matches) use (&$placeholderIndex) {
                $placeholder = "<<<PRESERVED_{$placeholderIndex}>>>";
                $this->preservedContent[$placeholder] = $matches[0];
                $placeholderIndex++;
                return $placeholder;
            },
            $text
        );
    }

    /**
     * Preserve brand names
     * 
     * @param string $text The text to process
     * @param int &$placeholderIndex Current placeholder index
     * @return string Text with brand names replaced by placeholders
     */
    private function preserveBrandNames(string $text, int &$placeholderIndex): string
    {
        foreach ($this->brandNames as $brand) {
            $pattern = '/\b' . preg_quote($brand, '/') . '\b/i';
            $text = preg_replace_callback(
                $pattern,
                function ($matches) use (&$placeholderIndex) {
                    $placeholder = "<<<PRESERVED_{$placeholderIndex}>>>";
                    $this->preservedContent[$placeholder] = $matches[0];
                    $placeholderIndex++;
                    return $placeholder;
                },
                $text
            );
        }

        return $text;
    }

    /**
     * Preserve custom patterns
     * 
     * @param string $text The text to process
     * @param int &$placeholderIndex Current placeholder index
     * @return string Text with custom patterns replaced by placeholders
     */
    private function preserveCustomPatterns(string $text, int &$placeholderIndex): string
    {
        foreach ($this->customPatterns as $pattern) {
            $text = preg_replace_callback(
                $pattern,
                function ($matches) use (&$placeholderIndex) {
                    $placeholder = "<<<PRESERVED_{$placeholderIndex}>>>";
                    $this->preservedContent[$placeholder] = $matches[0];
                    $placeholderIndex++;
                    return $placeholder;
                },
                $text
            );
        }

        return $text;
    }

    /**
     * Add a custom brand name
     * 
     * @param string $brand Brand name to preserve
     * @return self
     */
    public function addBrand(string $brand): self
    {
        if (!in_array($brand, $this->brandNames)) {
            $this->brandNames[] = $brand;
        }
        return $this;
    }

    /**
     * Add multiple brand names
     * 
     * @param array<string> $brands Array of brand names to preserve
     * @return self
     */
    public function addBrands(array $brands): self
    {
        $this->brandNames = array_unique(array_merge($this->brandNames, $brands));
        return $this;
    }

    /**
     * Add a custom pattern
     * 
     * @param string $pattern Regular expression pattern
     * @return self
     */
    public function addCustomPattern(string $pattern): self
    {
        if (!in_array($pattern, $this->customPatterns)) {
            $this->customPatterns[] = $pattern;
        }
        return $this;
    }

    /**
     * Update preservation settings
     * 
     * @param array<string, bool> $settings Settings to update
     * @return self
     */
    public function updateSettings(array $settings): self
    {
        $this->settings = array_merge($this->settings, $settings);
        return $this;
    }

    /**
     * Get current preservation settings
     * 
     * @return array<string, bool>
     */
    public function getSettings(): array
    {
        return $this->settings;
    }

    /**
     * Get list of brand names
     * 
     * @return array<string>
     */
    public function getBrands(): array
    {
        return $this->brandNames;
    }

    /**
     * Get list of custom patterns
     * 
     * @return array<string>
     */
    public function getCustomPatterns(): array
    {
        return $this->customPatterns;
    }

    /**
     * Clear all custom patterns
     * 
     * @return self
     */
    public function clearCustomPatterns(): self
    {
        $this->customPatterns = [];
        return $this;
    }

    /**
     * Detect preserved content types in text
     * 
     * @param string $text The text to analyze
     * @return array<string, int> Count of each detected content type
     */
    public function detectPreservedTypes(string $text): array
    {
        $detected = [];

        foreach ($this->patterns as $name => $pattern) {
            preg_match_all($pattern, $text, $matches);
            if (count($matches[0]) > 0) {
                $detected[$name] = count($matches[0]);
            }
        }

        $brandCount = 0;
        foreach ($this->brandNames as $brand) {
            $pattern = '/\b' . preg_quote($brand, '/') . '\b/i';
            preg_match_all($pattern, $text, $matches);
            $brandCount += count($matches[0]);
        }
        if ($brandCount > 0) {
            $detected['brands'] = $brandCount;
        }

        return $detected;
    }
}
