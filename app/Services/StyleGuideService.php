<?php

namespace App\Services;

/**
 * Academic and professional style guide service for Case Changer Pro
 * 
 * Implements formatting rules for 16 major style guides including APA, MLA, Chicago,
 * AP, Bluebook, IEEE, AMA, Harvard, Vancouver, OSCOLA, Reuters, Bloomberg, Oxford,
 * Cambridge, NY Times, and Wikipedia.
 * 
 * @package App\Services
 * @since 1.0.0
 */
class StyleGuideService
{
    /**
     * Apply APA (American Psychological Association) style
     * 
     * @param string $text The text to format
     * @param string $type The content type (title, heading, reference, etc.)
     * @return string Formatted text according to APA style
     */
    public function formatAPA(string $text, string $type = 'title'): string
    {
        switch ($type) {
            case 'title':
                return $this->applyTitleCase($text, ['and', 'as', 'but', 'for', 'if', 'nor', 'or', 'so', 'yet', 'a', 'an', 'the', 'at', 'by', 'for', 'in', 'of', 'on', 'to', 'up']);
            
            case 'heading1':
                return mb_convert_case($text, MB_CASE_TITLE);
            
            case 'heading2':
                return mb_convert_case($text, MB_CASE_TITLE);
            
            case 'heading3':
                return mb_convert_case($text, MB_CASE_TITLE);
            
            case 'heading4':
                $formatted = mb_convert_case($text, MB_CASE_TITLE);
                return rtrim($formatted, '.') . '.';
            
            case 'heading5':
                $formatted = mb_convert_case($text, MB_CASE_TITLE);
                return rtrim($formatted, '.') . '.';
            
            case 'reference':
                return $this->applySentenceCase($text);
            
            default:
                return $text;
        }
    }

    /**
     * Apply MLA (Modern Language Association) style
     * 
     * @param string $text The text to format
     * @param string $type The content type
     * @return string Formatted text according to MLA style
     */
    public function formatMLA(string $text, string $type = 'title'): string
    {
        switch ($type) {
            case 'title':
                return $this->applyTitleCase($text, ['a', 'an', 'the', 'and', 'but', 'for', 'nor', 'or', 'so', 'yet', 'at', 'by', 'in', 'of', 'on', 'to', 'up', 'as']);
            
            case 'heading':
                return $this->applyTitleCase($text, ['a', 'an', 'the', 'and', 'but', 'for', 'nor', 'or', 'so', 'yet']);
            
            case 'works_cited':
                return $this->applySentenceCase($text);
            
            default:
                return $text;
        }
    }

    /**
     * Apply Chicago Manual of Style
     * 
     * @param string $text The text to format
     * @param string $type The content type
     * @return string Formatted text according to Chicago style
     */
    public function formatChicago(string $text, string $type = 'title'): string
    {
        switch ($type) {
            case 'title':
                return $this->applyTitleCase($text, ['a', 'an', 'the', 'and', 'but', 'for', 'nor', 'or', 'so', 'yet', 'against', 'between', 'in', 'of', 'to', 'as']);
            
            case 'heading':
                return $this->applyTitleCase($text, ['a', 'an', 'the', 'and', 'but', 'or', 'nor']);
            
            case 'bibliography':
                return $this->applySentenceCase($text);
            
            default:
                return $text;
        }
    }

    /**
     * Apply AP (Associated Press) style
     * 
     * @param string $text The text to format
     * @param string $type The content type
     * @return string Formatted text according to AP style
     */
    public function formatAP(string $text, string $type = 'title'): string
    {
        switch ($type) {
            case 'title':
                $words = explode(' ', $text);
                $result = [];
                
                foreach ($words as $index => $word) {
                    $lower = mb_strtolower($word);
                    
                    if ($index === 0 || $index === count($words) - 1) {
                        $result[] = mb_convert_case($word, MB_CASE_TITLE);
                    }
                    elseif (in_array($lower, ['a', 'an', 'the', 'and', 'but', 'for', 'nor', 'or', 'so', 'yet', 'at', 'by', 'in', 'of', 'on', 'to', 'up']) && mb_strlen($word) < 4) {
                        $result[] = $lower;
                    }
                    else {
                        $result[] = mb_convert_case($word, MB_CASE_TITLE);
                    }
                }
                
                return implode(' ', $result);
            
            case 'dateline':
                return mb_strtoupper($text);
            
            default:
                return $text;
        }
    }

    /**
     * Apply Bluebook legal citation style
     * 
     * @param string $text The text to format
     * @param string $type The content type
     * @return string Formatted text according to Bluebook style
     */
    public function formatBluebook(string $text, string $type = 'title'): string
    {
        switch ($type) {
            case 'case_name':
                return $this->applyTitleCase($text, ['v.', 'vs.']);
            
            case 'article_title':
                return $this->applyTitleCase($text, ['a', 'an', 'the', 'and', 'but', 'for', 'nor', 'or', 'of', 'to']);
            
            case 'book_title':
                return mb_strtoupper($text);
            
            default:
                return $text;
        }
    }

    /**
     * Apply IEEE (Institute of Electrical and Electronics Engineers) style
     * 
     * @param string $text The text to format
     * @param string $type The content type
     * @return string Formatted text according to IEEE style
     */
    public function formatIEEE(string $text, string $type = 'title'): string
    {
        switch ($type) {
            case 'title':
                return $this->applySentenceCase($text, true);
            
            case 'section':
                return mb_strtoupper($text);
            
            case 'subsection':
                return $this->applySentenceCase($text);
            
            default:
                return $text;
        }
    }

    /**
     * Apply AMA (American Medical Association) style
     * 
     * @param string $text The text to format
     * @param string $type The content type
     * @return string Formatted text according to AMA style
     */
    public function formatAMA(string $text, string $type = 'title'): string
    {
        switch ($type) {
            case 'title':
                return $this->applyTitleCase($text, ['a', 'an', 'the', 'and', 'but', 'for', 'nor', 'or', 'with', 'at', 'by', 'from', 'in', 'of', 'on', 'to']);
            
            case 'journal_article':
                return $this->applySentenceCase($text);
            
            default:
                return $text;
        }
    }

    /**
     * Apply Harvard referencing style
     * 
     * @param string $text The text to format
     * @param string $type The content type
     * @return string Formatted text according to Harvard style
     */
    public function formatHarvard(string $text, string $type = 'title'): string
    {
        switch ($type) {
            case 'title':
                return $this->applySentenceCase($text);
            
            case 'book_title':
                return $this->applySentenceCase($text);
            
            case 'journal':
                return $this->applyTitleCase($text, ['and', 'of', 'the', 'in']);
            
            default:
                return $text;
        }
    }

    /**
     * Apply Vancouver style (biomedical)
     * 
     * @param string $text The text to format
     * @param string $type The content type
     * @return string Formatted text according to Vancouver style
     */
    public function formatVancouver(string $text, string $type = 'title'): string
    {
        switch ($type) {
            case 'title':
                return $this->applySentenceCase($text);
            
            case 'journal':
                $words = explode(' ', $text);
                $result = [];
                foreach ($words as $word) {
                    if (mb_strlen($word) > 3) {
                        $result[] = mb_substr($word, 0, 3) . '.';
                    } else {
                        $result[] = $word;
                    }
                }
                return implode(' ', $result);
            
            default:
                return $text;
        }
    }

    /**
     * Apply OSCOLA (Oxford University Standard for Citation of Legal Authorities) style
     * 
     * @param string $text The text to format
     * @param string $type The content type
     * @return string Formatted text according to OSCOLA style
     */
    public function formatOSCOLA(string $text, string $type = 'title'): string
    {
        switch ($type) {
            case 'case':
                return $this->applyTitleCase($text, ['v', 'and']);
            
            case 'article':
                return $this->applySentenceCase($text);
            
            case 'book':
                return $this->applyTitleCase($text, ['a', 'an', 'the', 'and', 'but', 'or', 'in', 'of', 'to']);
            
            default:
                return $text;
        }
    }

    /**
     * Apply Reuters style guide
     * 
     * @param string $text The text to format
     * @param string $type The content type
     * @return string Formatted text according to Reuters style
     */
    public function formatReuters(string $text, string $type = 'title'): string
    {
        switch ($type) {
            case 'headline':
                return $this->applySentenceCase($text, true);
            
            case 'dateline':
                $parts = explode(',', $text);
                if (count($parts) > 0) {
                    $parts[0] = mb_strtoupper(trim($parts[0]));
                }
                return implode(', ', $parts);
            
            default:
                return $text;
        }
    }

    /**
     * Apply Bloomberg style guide
     * 
     * @param string $text The text to format
     * @param string $type The content type
     * @return string Formatted text according to Bloomberg style
     */
    public function formatBloomberg(string $text, string $type = 'title'): string
    {
        switch ($type) {
            case 'headline':
                return $this->formatAP($text, 'title');
            
            case 'ticker':
                return mb_strtoupper($text);
            
            case 'company':
                return $text;
            
            default:
                return $text;
        }
    }

    /**
     * Apply Oxford style guide
     * 
     * @param string $text The text to format
     * @param string $type The content type
     * @return string Formatted text according to Oxford style
     */
    public function formatOxford(string $text, string $type = 'title'): string
    {
        switch ($type) {
            case 'title':
                return $this->applyTitleCase($text, ['a', 'an', 'the', 'and', 'but', 'or', 'nor', 'at', 'by', 'for', 'from', 'in', 'of', 'on', 'to', 'with']);
            
            case 'heading':
                return $this->applySentenceCase($text);
            
            default:
                return $text;
        }
    }

    /**
     * Apply Cambridge style guide
     * 
     * @param string $text The text to format
     * @param string $type The content type
     * @return string Formatted text according to Cambridge style
     */
    public function formatCambridge(string $text, string $type = 'title'): string
    {
        switch ($type) {
            case 'title':
                return $this->applyTitleCase($text, ['a', 'an', 'the', 'and', 'but', 'or', 'nor', 'as', 'at', 'by', 'for', 'in', 'of', 'on', 'to']);
            
            case 'chapter':
                return $this->applyTitleCase($text, ['a', 'an', 'the', 'and', 'but', 'or']);
            
            default:
                return $text;
        }
    }

    /**
     * Apply New York Times style
     * 
     * @param string $text The text to format
     * @param string $type The content type
     * @return string Formatted text according to NY Times style
     */
    public function formatNYTimes(string $text, string $type = 'title'): string
    {
        switch ($type) {
            case 'headline':
                return $this->applyTitleCase($text, ['a', 'an', 'the', 'and', 'but', 'for', 'nor', 'or', 'so', 'yet']);
            
            case 'byline':
                return mb_convert_case($text, MB_CASE_TITLE);
            
            default:
                return $text;
        }
    }

    /**
     * Apply Wikipedia Manual of Style
     * 
     * @param string $text The text to format
     * @param string $type The content type
     * @return string Formatted text according to Wikipedia style
     */
    public function formatWikipedia(string $text, string $type = 'title'): string
    {
        switch ($type) {
            case 'article_title':
                return $this->applySentenceCase($text, true);
            
            case 'section_heading':
                return $this->applySentenceCase($text);
            
            case 'image_caption':
                $formatted = $this->applySentenceCase($text);
                if (!preg_match('/[.!?]$/', $formatted)) {
                    $formatted .= '.';
                }
                return $formatted;
            
            default:
                return $text;
        }
    }

    /**
     * Apply title case with specified exceptions
     * 
     * @param string $text The text to format
     * @param array<string> $exceptions Words to keep lowercase
     * @return string Text in title case
     */
    private function applyTitleCase(string $text, array $exceptions = []): string
    {
        $words = preg_split('/\s+/', $text);
        $result = [];
        
        foreach ($words as $index => $word) {
            $lower = mb_strtolower($word);
            
            if ($index === 0 || $index === count($words) - 1) {
                $result[] = mb_convert_case($word, MB_CASE_TITLE);
            }
            elseif (in_array($lower, $exceptions)) {
                $result[] = $lower;
            }
            else {
                $result[] = mb_convert_case($word, MB_CASE_TITLE);
            }
        }
        
        return implode(' ', $result);
    }

    /**
     * Apply sentence case
     * 
     * @param string $text The text to format
     * @param bool $preserveProperNouns Whether to preserve proper nouns
     * @return string Text in sentence case
     */
    private function applySentenceCase(string $text, bool $preserveProperNouns = false): string
    {
        $sentences = preg_split('/([.!?]\s+)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
        $result = [];
        
        foreach ($sentences as $sentence) {
            if (empty(trim($sentence))) {
                continue;
            }
            
            if (preg_match('/^[.!?]\s+$/', $sentence)) {
                $result[] = $sentence;
            } else {
                $formatted = mb_strtolower($sentence);
                $formatted = mb_strtoupper(mb_substr($formatted, 0, 1)) . mb_substr($formatted, 1);
                
                if ($preserveProperNouns) {
                    $properNouns = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday',
                                  'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                                  'September', 'October', 'November', 'December'];
                    
                    foreach ($properNouns as $noun) {
                        $formatted = preg_replace('/\b' . mb_strtolower($noun) . '\b/i', $noun, $formatted);
                    }
                }
                
                $result[] = $formatted;
            }
        }
        
        return implode('', $result);
    }

    /**
     * Get all available style guides
     * 
     * @return array<string> List of available style guide names
     */
    public function getAvailableStyles(): array
    {
        return [
            'APA' => 'American Psychological Association',
            'MLA' => 'Modern Language Association',
            'Chicago' => 'Chicago Manual of Style',
            'AP' => 'Associated Press',
            'Bluebook' => 'Legal Citation',
            'IEEE' => 'Institute of Electrical and Electronics Engineers',
            'AMA' => 'American Medical Association',
            'Harvard' => 'Harvard Referencing',
            'Vancouver' => 'Biomedical',
            'OSCOLA' => 'Oxford Legal',
            'Reuters' => 'Reuters Style',
            'Bloomberg' => 'Bloomberg Style',
            'Oxford' => 'Oxford Style',
            'Cambridge' => 'Cambridge Style',
            'NYTimes' => 'New York Times',
            'Wikipedia' => 'Wikipedia Manual of Style'
        ];
    }

    /**
     * Apply style guide to text
     * 
     * @param string $text The text to format
     * @param string $style The style guide name
     * @param string $type The content type
     * @return string Formatted text
     */
    public function applyStyle(string $text, string $style, string $type = 'title'): string
    {
        $method = 'format' . $style;
        
        if (method_exists($this, $method)) {
            return $this->$method($text, $type);
        }
        
        return $text;
    }

    /**
     * Main style guide formatter dispatcher method
     * Routes formatting requests to appropriate style guide methods
     * 
     * @param string $text The text to format
     * @param string $style The style guide to apply
     * @param string $type The content type (title, heading, reference, etc.)
     * @return string Formatted text according to the specified style guide
     * @throws \InvalidArgumentException If style guide is not supported
     */
    public function format(string $text, string $style, string $type = 'title'): string
    {
        $styleMap = [
            'apa' => 'formatAPA',
            'mla' => 'formatMLA',
            'chicago' => 'formatChicago',
            'harvard' => 'formatHarvard',
            'ieee' => 'formatIEEE',
            'ama' => 'formatAMA',
            'vancouver' => 'formatVancouver',
            'ap' => 'formatAP',
            'nytimes' => 'formatNYTimes',
            'reuters' => 'formatReuters',
            'bloomberg' => 'formatBloomberg',
            'wikipedia' => 'formatWikipedia',
            'bluebook' => 'formatBluebook',
            'oscola' => 'formatOSCOLA',
            'oxford' => 'formatOxford',
            'cambridge' => 'formatCambridge'
        ];
        
        $style = strtolower($style);
        
        if (!isset($styleMap[$style])) {
            $upperStyle = strtoupper($style);
            if (isset($styleMap[strtolower($upperStyle)])) {
                $style = strtolower($upperStyle);
            } else {
                throw new \InvalidArgumentException("Unsupported style guide: {$style}");
            }
        }
        
        $method = $styleMap[$style];
        
        if (method_exists($this, $method)) {
            return $this->$method($text, $type);
        }
        
        throw new \InvalidArgumentException("Method not found for style: {$style}");
    }
}
