<?php

namespace App\Services;

/**
 * Writing and journalism-specific tools service
 * Provides specialized text formatting for writers and journalists
 */
class WritingToolsService
{
    /**
     * Convert straight quotes to curly/smart quotes
     */
    public function toSmartQuotes(string $text): string
    {
        
        
        return $text;
    }
    
    /**
     * Convert curly/smart quotes to straight quotes
     */
    public function toStraightQuotes(string $text): string
    {
        $text = str_replace(['"', '"', '„', '‟', '〝', '〞', '＂'], '"', $text);
        
        $text = str_replace([''', ''', '‚', '‛', '〝', '〞', '＇'], "'", $text);
        
        return $text;
    }
    
    /**
     * Calculate headline score based on various factors
     * Returns score 0-100 and analysis
     */
    public function getHeadlineScore(string $headline): array
    {
        $score = 100;
        $feedback = [];
        
        $wordCount = str_word_count($headline);
        $charCount = strlen($headline);
        
        if ($wordCount < 4) {
            $score -= 15;
            $feedback[] = 'Too short - aim for 6-12 words';
        } elseif ($wordCount > 15) {
            $score -= 10;
            $feedback[] = 'Too long - keep it under 12 words for impact';
        } elseif ($wordCount >= 6 && $wordCount <= 12) {
            $feedback[] = '✓ Good length (6-12 words)';
        }
        
        if ($charCount > 100) {
            $score -= 10;
            $feedback[] = 'Too many characters - aim for 50-70';
        } elseif ($charCount >= 50 && $charCount <= 70) {
            $feedback[] = '✓ Optimal character count';
        }
        
        $powerWords = ['amazing', 'incredible', 'essential', 'proven', 'guaranteed', 'exclusive',
                      'revolutionary', 'breakthrough', 'discover', 'secret', 'powerful', 'ultimate',
                      'complete', 'comprehensive', 'definitive', 'expert', 'professional'];
        
        $hasPowerWord = false;
        foreach ($powerWords as $word) {
            if (stripos($headline, $word) !== false) {
                $hasPowerWord = true;
                break;
            }
        }
        
        if ($hasPowerWord) {
            $feedback[] = '✓ Contains power word';
        } else {
            $score -= 10;
            $feedback[] = 'Consider adding a power word for impact';
        }
        
        $emotionalWords = ['love', 'hate', 'fear', 'angry', 'happy', 'sad', 'excited',
                          'worried', 'surprised', 'disgusted', 'trust', 'anticipate'];
        
        $hasEmotional = false;
        foreach ($emotionalWords as $word) {
            if (stripos($headline, $word) !== false) {
                $hasEmotional = true;
                break;
            }
        }
        
        if ($hasEmotional) {
            $feedback[] = '✓ Contains emotional trigger';
        }
        
        if (preg_match('/\d+/', $headline)) {
            $feedback[] = '✓ Contains numbers (increases clicks)';
        } else {
            $score -= 5;
            $feedback[] = 'Consider adding numbers (e.g., "5 Ways to...")';
        }
        
        if (str_ends_with($headline, '?')) {
            $feedback[] = '✓ Question format engages readers';
        }
        
        if (stripos($headline, 'how to') !== false || stripos($headline, 'how-to') !== false) {
            $feedback[] = '✓ How-to format is highly engaging';
        }
        
        $urgencyWords = ['now', 'today', 'limited', 'deadline', 'expires', 'hurry', 'quick', 'fast'];
        foreach ($urgencyWords as $word) {
            if (stripos($headline, $word) !== false) {
                $feedback[] = '✓ Creates sense of urgency';
                break;
            }
        }
        
        $vagueWords = ['thing', 'stuff', 'whatever', 'some', 'any'];
        foreach ($vagueWords as $word) {
            if (stripos($headline, $word) !== false) {
                $score -= 5;
                $feedback[] = 'Avoid vague words like "' . $word . '"';
                break;
            }
        }
        
        if (strtoupper($headline) === $headline && strlen($headline) > 3) {
            $score -= 15;
            $feedback[] = 'Avoid ALL CAPS - it looks spammy';
        }
        
        $score = max(0, min(100, $score));
        
        return [
            'score' => $score,
            'grade' => $this->getGrade($score),
            'feedback' => $feedback,
            'word_count' => $wordCount,
            'character_count' => $charCount
        ];
    }
    
    /**
     * Calculate email subject line score
     */
    public function getEmailSubjectScore(string $subject): array
    {
        $score = 100;
        $feedback = [];
        
        $charCount = strlen($subject);
        
        if ($charCount < 20) {
            $score -= 10;
            $feedback[] = 'Too short - aim for 30-50 characters';
        } elseif ($charCount > 60) {
            $score -= 15;
            $feedback[] = 'Too long - will be cut off on mobile (keep under 50)';
        } elseif ($charCount >= 30 && $charCount <= 50) {
            $feedback[] = '✓ Perfect length for all devices';
        }
        
        if (preg_match('/\{.*?\}|\[.*?\]/', $subject)) {
            $feedback[] = '✓ Contains personalization tokens';
        }
        
        $spamWords = ['free', 'click here', 'buy now', 'limited time', 'act now', 'urgent',
                     'congratulations', 'winner', 'prize', '100%', 'guarantee', 'no obligation',
                     'risk-free', 'cancel', 'cheap', 'dear friend', 'double your', 'earn $',
                     'extra income', 'make money', 'million', 'mortgage', 'no cost', 'pennies',
                     'save $', 'viagra', 'weight loss'];
        
        $spamCount = 0;
        foreach ($spamWords as $word) {
            if (stripos($subject, $word) !== false) {
                $spamCount++;
                $score -= 10;
                $feedback[] = 'Avoid spam trigger: "' . $word . '"';
            }
        }
        
        if ($spamCount === 0) {
            $feedback[] = '✓ No spam triggers detected';
        }
        
        if (preg_match('/[\x{1F600}-\x{1F64F}]|[\x{1F300}-\x{1F5FF}]|[\x{1F680}-\x{1F6FF}]|[\x{2600}-\x{26FF}]|[\x{2700}-\x{27BF}]/u', $subject)) {
            $feedback[] = '✓ Contains emoji (can increase open rates)';
        }
        
        if (str_ends_with($subject, '?')) {
            $feedback[] = '✓ Question format increases curiosity';
        }
        
        if (preg_match('/\d+/', $subject)) {
            $feedback[] = '✓ Contains numbers (improves open rates)';
        }
        
        if (strtoupper($subject) === $subject && strlen($subject) > 3) {
            $score -= 20;
            $feedback[] = 'Never use ALL CAPS - major spam signal';
        }
        
        if (preg_match('/[!]{2,}|[?]{2,}/', $subject)) {
            $score -= 15;
            $feedback[] = 'Avoid excessive punctuation (!!!???)';
        }
        
        if (preg_match('/[<>]/', $subject)) {
            $score -= 10;
            $feedback[] = 'Avoid < > characters - may break in some clients';
        }
        
        $actionWords = ['discover', 'learn', 'get', 'start', 'join', 'find', 'see', 'download'];
        foreach ($actionWords as $word) {
            if (stripos($subject, $word) !== false) {
                $feedback[] = '✓ Contains action word';
                break;
            }
        }
        
        $score = max(0, min(100, $score));
        
        return [
            'score' => $score,
            'grade' => $this->getGrade($score),
            'feedback' => $feedback,
            'character_count' => $charCount,
            'mobile_preview' => mb_substr($subject, 0, 30) . (strlen($subject) > 30 ? '...' : ''),
            'desktop_preview' => mb_substr($subject, 0, 50) . (strlen($subject) > 50 ? '...' : '')
        ];
    }
    
    /**
     * Toggle case - invert the case of each character
     */
    public function toggleCase(string $text): string
    {
        $result = '';
        $chars = mb_str_split($text);
        
        foreach ($chars as $char) {
            if (mb_strtoupper($char) === $char) {
                $result .= mb_strtolower($char);
            } else {
                $result .= mb_strtoupper($char);
            }
        }
        
        return $result;
    }
    
    /**
     * Proper case - capitalize first letter of every word
     */
    public function toProperCase(string $text): string
    {
        return mb_convert_case($text, MB_CASE_TITLE);
    }
    
    /**
     * Email case - proper formatting for email
     * Capitalizes first word of sentences, preserves URLs and email addresses
     */
    public function toEmailCase(string $text): string
    {
        $urls = [];
        $emails = [];
        
        $text = preg_replace_callback(
            '/(https?:\/\/[^\s]+)/i',
            function($matches) use (&$urls) {
                $placeholder = '{{URL_' . count($urls) . '}}';
                $urls[] = $matches[0];
                return $placeholder;
            },
            $text
        );
        
        $text = preg_replace_callback(
            '/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/i',
            function($matches) use (&$emails) {
                $placeholder = '{{EMAIL_' . count($emails) . '}}';
                $emails[] = $matches[0];
                return $placeholder;
            },
            $text
        );
        
        $sentences = preg_split('/([.!?]\s+)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
        $result = [];
        
        foreach ($sentences as $sentence) {
            if (empty(trim($sentence))) {
                continue;
            }
            
            if (preg_match('/^[.!?]\s+$/', $sentence)) {
                $result[] = $sentence;
            } else {
                $formatted = trim($sentence);
                if (strlen($formatted) > 0) {
                    $formatted = mb_strtoupper(mb_substr($formatted, 0, 1)) . mb_substr($formatted, 1);
                }
                $result[] = $formatted;
            }
        }
        
        $text = implode('', $result);
        
        foreach ($urls as $i => $url) {
            $text = str_replace('{{URL_' . $i . '}}', $url, $text);
        }
        
        foreach ($emails as $i => $email) {
            $text = str_replace('{{EMAIL_' . $i . '}}', $email, $text);
        }
        
        return $text;
    }
    
    /**
     * Get grade based on score
     */
    private function getGrade(int $score): string
    {
        if ($score >= 90) return 'A+';
        if ($score >= 85) return 'A';
        if ($score >= 80) return 'A-';
        if ($score >= 75) return 'B+';
        if ($score >= 70) return 'B';
        if ($score >= 65) return 'B-';
        if ($score >= 60) return 'C+';
        if ($score >= 55) return 'C';
        if ($score >= 50) return 'C-';
        if ($score >= 45) return 'D+';
        if ($score >= 40) return 'D';
        return 'F';
    }
    
    /**
     * Alternative case - capitalize every other letter
     */
    public function toAlternatingCase(string $text): string
    {
        $result = '';
        $chars = mb_str_split($text);
        $letterCount = 0;
        
        foreach ($chars as $char) {
            if (preg_match('/\p{L}/u', $char)) {
                if ($letterCount % 2 === 0) {
                    $result .= mb_strtoupper($char);
                } else {
                    $result .= mb_strtolower($char);
                }
                $letterCount++;
            } else {
                $result .= $char;
            }
        }
        
        return $result;
    }
}