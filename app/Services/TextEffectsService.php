<?php

namespace App\Services;

/**
 * Text Effects Service
 * Handles Unicode-based text transformations for visual effects
 */
class TextEffectsService
{
    private const BOLD_UPPER = ['A' => '𝗔', 'B' => '𝗕', 'C' => '𝗖', 'D' => '𝗗', 'E' => '𝗘', 'F' => '𝗙', 'G' => '𝗚', 'H' => '𝗛', 'I' => '𝗜', 'J' => '𝗝', 'K' => '𝗞', 'L' => '𝗟', 'M' => '𝗠', 'N' => '𝗡', 'O' => '𝗢', 'P' => '𝗣', 'Q' => '𝗤', 'R' => '𝗥', 'S' => '𝗦', 'T' => '𝗧', 'U' => '𝗨', 'V' => '𝗩', 'W' => '𝗪', 'X' => '𝗫', 'Y' => '𝗬', 'Z' => '𝗭'];
    private const BOLD_LOWER = ['a' => '𝗮', 'b' => '𝗯', 'c' => '𝗰', 'd' => '𝗱', 'e' => '𝗲', 'f' => '𝗳', 'g' => '𝗴', 'h' => '𝗵', 'i' => '𝗶', 'j' => '𝗷', 'k' => '𝗸', 'l' => '𝗹', 'm' => '𝗺', 'n' => '𝗻', 'o' => '𝗼', 'p' => '𝗽', 'q' => '𝗾', 'r' => '𝗿', 's' => '𝘀', 't' => '𝘁', 'u' => '𝘂', 'v' => '𝘃', 'w' => '𝘄', 'x' => '𝘅', 'y' => '𝘆', 'z' => '𝘇'];
    private const BOLD_DIGITS = ['0' => '𝟬', '1' => '𝟭', '2' => '𝟮', '3' => '𝟯', '4' => '𝟰', '5' => '𝟱', '6' => '𝟲', '7' => '𝟳', '8' => '𝟴', '9' => '𝟵'];
    
    private const ITALIC_UPPER = ['A' => '𝘈', 'B' => '𝘉', 'C' => '𝘊', 'D' => '𝘋', 'E' => '𝘌', 'F' => '𝘍', 'G' => '𝘎', 'H' => '𝘏', 'I' => '𝘐', 'J' => '𝘑', 'K' => '𝘒', 'L' => '𝘓', 'M' => '𝘔', 'N' => '𝘕', 'O' => '𝘖', 'P' => '𝘗', 'Q' => '𝘘', 'R' => '𝘙', 'S' => '𝘚', 'T' => '𝘛', 'U' => '𝘜', 'V' => '𝘝', 'W' => '𝘞', 'X' => '𝘟', 'Y' => '𝘠', 'Z' => '𝘡'];
    private const ITALIC_LOWER = ['a' => '𝘢', 'b' => '𝘣', 'c' => '𝘤', 'd' => '𝘥', 'e' => '𝘦', 'f' => '𝘧', 'g' => '𝘨', 'h' => '𝘩', 'i' => '𝘪', 'j' => '𝘫', 'k' => '𝘬', 'l' => '𝘭', 'm' => '𝘮', 'n' => '𝘯', 'o' => '𝘰', 'p' => '𝘱', 'q' => '𝘲', 'r' => '𝘳', 's' => '𝘴', 't' => '𝘵', 'u' => '𝘶', 'v' => '𝘷', 'w' => '𝘸', 'x' => '𝘹', 'y' => '𝘺', 'z' => '𝘻'];
    
    private const STRIKETHROUGH_CHAR = '̶';
    private const UNDERLINE_CHAR = '̲';
    
    private const BUBBLE_MAP = [
        'A' => 'Ⓐ', 'B' => 'Ⓑ', 'C' => 'Ⓒ', 'D' => 'Ⓓ', 'E' => 'Ⓔ', 'F' => 'Ⓕ', 'G' => 'Ⓖ', 'H' => 'Ⓗ', 'I' => 'Ⓘ', 'J' => 'Ⓙ', 'K' => 'Ⓚ', 'L' => 'Ⓛ', 'M' => 'Ⓜ', 'N' => 'Ⓝ', 'O' => 'Ⓞ', 'P' => 'Ⓟ', 'Q' => 'Ⓠ', 'R' => 'Ⓡ', 'S' => 'Ⓢ', 'T' => 'Ⓣ', 'U' => 'Ⓤ', 'V' => 'Ⓥ', 'W' => 'Ⓦ', 'X' => 'Ⓧ', 'Y' => 'Ⓨ', 'Z' => 'Ⓩ',
        'a' => 'ⓐ', 'b' => 'ⓑ', 'c' => 'ⓒ', 'd' => 'ⓓ', 'e' => 'ⓔ', 'f' => 'ⓕ', 'g' => 'ⓖ', 'h' => 'ⓗ', 'i' => 'ⓘ', 'j' => 'ⓙ', 'k' => 'ⓚ', 'l' => 'ⓛ', 'm' => 'ⓜ', 'n' => 'ⓝ', 'o' => 'ⓞ', 'p' => 'ⓟ', 'q' => 'ⓠ', 'r' => 'ⓡ', 's' => 'ⓢ', 't' => 'ⓣ', 'u' => 'ⓤ', 'v' => 'ⓥ', 'w' => 'ⓦ', 'x' => 'ⓧ', 'y' => 'ⓨ', 'z' => 'ⓩ',
        '0' => '⓪', '1' => '①', '2' => '②', '3' => '③', '4' => '④', '5' => '⑤', '6' => '⑥', '7' => '⑦', '8' => '⑧', '9' => '⑨'
    ];
    
    private const SQUARE_MAP = [
        'A' => '🄰', 'B' => '🄱', 'C' => '🄲', 'D' => '🄳', 'E' => '🄴', 'F' => '🄵', 'G' => '🄶', 'H' => '🄷', 'I' => '🄸', 'J' => '🄹', 'K' => '🄺', 'L' => '🄻', 'M' => '🄼', 'N' => '🄽', 'O' => '🄾', 'P' => '🄿', 'Q' => '🅀', 'R' => '🅁', 'S' => '🅂', 'T' => '🅃', 'U' => '🅄', 'V' => '🅅', 'W' => '🅆', 'X' => '🅇', 'Y' => '🅈', 'Z' => '🅉'
    ];
    
    private const UPSIDE_DOWN_MAP = [
        'A' => '∀', 'B' => 'ᙠ', 'C' => 'Ɔ', 'D' => 'ᗡ', 'E' => 'Ǝ', 'F' => 'Ⅎ', 'G' => '⅁', 'H' => 'H', 'I' => 'I', 'J' => 'ſ', 'K' => 'ʞ', 'L' => '˥', 'M' => 'W', 'N' => 'N', 'O' => 'O', 'P' => 'Ԁ', 'Q' => 'Ὸ', 'R' => 'ᴚ', 'S' => 'S', 'T' => '⊥', 'U' => '∩', 'V' => 'Λ', 'W' => 'M', 'X' => 'X', 'Y' => '⅄', 'Z' => 'Z',
        'a' => 'ɐ', 'b' => 'q', 'c' => 'ɔ', 'd' => 'p', 'e' => 'ǝ', 'f' => 'ɟ', 'g' => 'ƃ', 'h' => 'ɥ', 'i' => 'ᴉ', 'j' => 'ɾ', 'k' => 'ʞ', 'l' => 'l', 'm' => 'ɯ', 'n' => 'u', 'o' => 'o', 'p' => 'd', 'q' => 'b', 'r' => 'ɹ', 's' => 's', 't' => 'ʇ', 'u' => 'n', 'v' => 'ʌ', 'w' => 'ʍ', 'x' => 'x', 'y' => 'ʎ', 'z' => 'z',
        '0' => '0', '1' => 'Ɩ', '2' => 'ᄅ', '3' => 'Ɛ', '4' => 'ㄣ', '5' => 'ϛ', '6' => '9', '7' => 'ㄥ', '8' => '8', '9' => '6',
        '!' => '¡', '?' => '¿', '.' => '˙', ',' => '\'', '\'' => ',', '"' => '„', ';' => '؛', '(' => ')', ')' => '(', '[' => ']', ']' => '[', '{' => '}', '}' => '{', '<' => '>', '>' => '<'
    ];
    
    private const WIDE_MAP = [
        'A' => 'Ａ', 'B' => 'Ｂ', 'C' => 'Ｃ', 'D' => 'Ｄ', 'E' => 'Ｅ', 'F' => 'Ｆ', 'G' => 'Ｇ', 'H' => 'Ｈ', 'I' => 'Ｉ', 'J' => 'Ｊ', 'K' => 'Ｋ', 'L' => 'Ｌ', 'M' => 'Ｍ', 'N' => 'Ｎ', 'O' => 'Ｏ', 'P' => 'Ｐ', 'Q' => 'Ｑ', 'R' => 'Ｒ', 'S' => 'Ｓ', 'T' => 'Ｔ', 'U' => 'Ｕ', 'V' => 'Ｖ', 'W' => 'Ｗ', 'X' => 'Ｘ', 'Y' => 'Ｙ', 'Z' => 'Ｚ',
        'a' => 'ａ', 'b' => 'ｂ', 'c' => 'ｃ', 'd' => 'ｄ', 'e' => 'ｅ', 'f' => 'ｆ', 'g' => 'ｇ', 'h' => 'ｈ', 'i' => 'ｉ', 'j' => 'ｊ', 'k' => 'ｋ', 'l' => 'ｌ', 'm' => 'ｍ', 'n' => 'ｎ', 'o' => 'ｏ', 'p' => 'ｐ', 'q' => 'ｑ', 'r' => 'ｒ', 's' => 'ｓ', 't' => 'ｔ', 'u' => 'ｕ', 'v' => 'ｖ', 'w' => 'ｗ', 'x' => 'ｘ', 'y' => 'ｙ', 'z' => 'ｚ',
        '0' => '０', '1' => '１', '2' => '２', '3' => '３', '4' => '４', '5' => '５', '6' => '６', '7' => '７', '8' => '８', '9' => '９',
        ' ' => '　', '!' => '！', '"' => '＂', '#' => '＃', '$' => '＄', '%' => '％', '&' => '＆', '\'' => '＇', '(' => '（', ')' => '）', '*' => '＊', '+' => '＋', ',' => '，', '-' => '－', '.' => '．', '/' => '／'
    ];

    /**
     * Convert text to bold Unicode characters
     */
    public function toBold(string $text): string
    {
        return $this->applyCharMap($text, array_merge(self::BOLD_UPPER, self::BOLD_LOWER, self::BOLD_DIGITS));
    }

    /**
     * Convert text to italic Unicode characters
     */
    public function toItalic(string $text): string
    {
        return $this->applyCharMap($text, array_merge(self::ITALIC_UPPER, self::ITALIC_LOWER));
    }

    /**
     * Add strikethrough to text
     */
    public function toStrikethrough(string $text): string
    {
        $result = '';
        for ($i = 0; $i < mb_strlen($text); $i++) {
            $char = mb_substr($text, $i, 1);
            $result .= $char . self::STRIKETHROUGH_CHAR;
        }
        return $result;
    }

    /**
     * Add underline to text
     */
    public function toUnderline(string $text): string
    {
        $result = '';
        for ($i = 0; $i < mb_strlen($text); $i++) {
            $char = mb_substr($text, $i, 1);
            $result .= $char . self::UNDERLINE_CHAR;
        }
        return $result;
    }

    /**
     * Convert text to bubble/circle characters
     */
    public function toBubble(string $text): string
    {
        return $this->applyCharMap($text, self::BUBBLE_MAP);
    }

    /**
     * Convert text to square characters
     */
    public function toSquare(string $text): string
    {
        return $this->applyCharMap(strtoupper($text), self::SQUARE_MAP);
    }

    /**
     * Convert text to upside down
     */
    public function toUpsideDown(string $text): string
    {
        $result = $this->applyCharMap($text, self::UPSIDE_DOWN_MAP);
        return strrev($result);
    }

    /**
     * Convert text to wide/fullwidth characters
     */
    public function toWide(string $text): string
    {
        return $this->applyCharMap($text, self::WIDE_MAP);
    }

    /**
     * Mirror/reverse text
     */
    public function toMirror(string $text): string
    {
        return strrev($text);
    }

    /**
     * Generate Zalgo text with diacritics
     */
    public function toZalgo(string $text, int $intensity = 5): string
    {
        $zalgoUp = ['̍', '̎', '̄', '̅', '̿', '̑', '̆', '̐', '͒', '͗', '͑', '̇', '̈', '̊', '͂', '̓', '̈́', '͊', '͋', '͌', '̃', '̂', '̌', '͐', '̀', '́', '̋', '̏', '̒', '̓', '̔', '̽', '̉', 'ͣ', 'ͤ', 'ͥ', 'ͦ', 'ͧ', 'ͨ', 'ͩ', 'ͪ', 'ͫ', 'ͬ', 'ͭ', 'ͮ', 'ͯ', '̾', '͛', '͆', '̚'];
        $zalgoDown = ['̖', '̗', '̘', '̙', '̜', '̝', '̞', '̟', '̠', '̤', '̥', '̦', '̩', '̪', '̫', '̬', '̭', '̮', '̯', '̰', '̱', '̲', '̳', '̹', '̺', '̻', '̼', 'ͅ', '͇', '͈', '͉', '͍', '͎', '͓', '͔', '͕', '͖', '͙', '͚', '̣'];
        $zalgoMid = ['̕', '̛', '̀', '́', '͘', '̡', '̢', '̧', '̨', '̴', '̵', '̶', '͏', '͜', '͝', '͞', '͟', '͠', '͢', '̸', '̷', '͡'];
        
        $result = '';
        for ($i = 0; $i < mb_strlen($text); $i++) {
            $char = mb_substr($text, $i, 1);
            $result .= $char;
            
            for ($j = 0; $j < $intensity; $j++) {
                if (rand(0, 100) < 50) {
                    $result .= $zalgoUp[array_rand($zalgoUp)];
                }
                if (rand(0, 100) < 50) {
                    $result .= $zalgoDown[array_rand($zalgoDown)];
                }
                if (rand(0, 100) < 50) {
                    $result .= $zalgoMid[array_rand($zalgoMid)];
                }
            }
        }
        return $result;
    }

    /**
     * Convert to cursed text (combination of effects)
     */
    public function toCursed(string $text): string
    {
        $text = $this->toZalgo($text, 3);
        return $text;
    }

    /**
     * Generate invisible text using zero-width characters
     */
    public function toInvisible(string $text): string
    {
        $zeroWidth = ["\u{200B}", "\u{200C}", "\u{200D}", "\u{FEFF}"];
        $binary = [];
        
        for ($i = 0; $i < mb_strlen($text); $i++) {
            $char = mb_substr($text, $i, 1);
            $ord = mb_ord($char);
            $bin = decbin($ord);
            
            $encoded = '';
            for ($j = 0; $j < strlen($bin); $j++) {
                $encoded .= $bin[$j] === '1' ? $zeroWidth[0] : $zeroWidth[1];
            }
            $binary[] = $encoded;
        }
        
        return implode($zeroWidth[2], $binary);
    }

    /**
     * Convert text to superscript
     */
    public function toSuperscript(string $text): string
    {
        $map = [
            'a' => 'ᵃ', 'b' => 'ᵇ', 'c' => 'ᶜ', 'd' => 'ᵈ', 'e' => 'ᵉ', 'f' => 'ᶠ', 'g' => 'ᵍ', 'h' => 'ʰ', 'i' => 'ⁱ', 'j' => 'ʲ', 'k' => 'ᵏ', 'l' => 'ˡ', 'm' => 'ᵐ', 'n' => 'ⁿ', 'o' => 'ᵒ', 'p' => 'ᵖ', 'r' => 'ʳ', 's' => 'ˢ', 't' => 'ᵗ', 'u' => 'ᵘ', 'v' => 'ᵛ', 'w' => 'ʷ', 'x' => 'ˣ', 'y' => 'ʸ', 'z' => 'ᶻ',
            'A' => 'ᴬ', 'B' => 'ᴮ', 'D' => 'ᴰ', 'E' => 'ᴱ', 'G' => 'ᴳ', 'H' => 'ᴴ', 'I' => 'ᴵ', 'J' => 'ᴶ', 'K' => 'ᴷ', 'L' => 'ᴸ', 'M' => 'ᴹ', 'N' => 'ᴺ', 'O' => 'ᴼ', 'P' => 'ᴾ', 'R' => 'ᴿ', 'T' => 'ᵀ', 'U' => 'ᵁ', 'V' => 'ⱽ', 'W' => 'ᵂ',
            '0' => '⁰', '1' => '¹', '2' => '²', '3' => '³', '4' => '⁴', '5' => '⁵', '6' => '⁶', '7' => '⁷', '8' => '⁸', '9' => '⁹',
            '+' => '⁺', '-' => '⁻', '=' => '⁼', '(' => '⁽', ')' => '⁾'
        ];
        return $this->applyCharMap($text, $map);
    }

    /**
     * Convert text to subscript
     */
    public function toSubscript(string $text): string
    {
        $map = [
            'a' => 'ₐ', 'e' => 'ₑ', 'h' => 'ₕ', 'i' => 'ᵢ', 'j' => 'ⱼ', 'k' => 'ₖ', 'l' => 'ₗ', 'm' => 'ₘ', 'n' => 'ₙ', 'o' => 'ₒ', 'p' => 'ₚ', 'r' => 'ᵣ', 's' => 'ₛ', 't' => 'ₜ', 'u' => 'ᵤ', 'v' => 'ᵥ', 'x' => 'ₓ',
            '0' => '₀', '1' => '₁', '2' => '₂', '3' => '₃', '4' => '₄', '5' => '₅', '6' => '₆', '7' => '₇', '8' => '₈', '9' => '₉',
            '+' => '₊', '-' => '₋', '=' => '₌', '(' => '₍', ')' => '₎'
        ];
        return $this->applyCharMap($text, $map);
    }

    /**
     * Remove all formatting and return plain text
     */
    public function toPlainText(string $text): string
    {
        
        
        return $text;
    }

    /**
     * Apply character mapping to text
     */
    private function applyCharMap(string $text, array $map): string
    {
        $result = '';
        for ($i = 0; $i < mb_strlen($text); $i++) {
            $char = mb_substr($text, $i, 1);
            $result .= $map[$char] ?? $char;
        }
        return $result;
    }
}