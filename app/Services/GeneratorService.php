<?php

namespace App\Services;

/**
 * Random Generator Service
 * Handles generation of random data, passwords, IDs, etc.
 */
class GeneratorService
{
    /**
     * Generate strong password
     */
    public function generatePassword(int $length = 16, array $options = []): string
    {
        $defaults = [
            'uppercase' => true,
            'lowercase' => true,
            'numbers' => true,
            'symbols' => true,
            'exclude_ambiguous' => false
        ];
        
        $options = array_merge($defaults, $options);
        
        $chars = '';
        if ($options['lowercase']) {
            $chars .= $options['exclude_ambiguous'] ? 'abcdefghjkmnpqrstuvwxyz' : 'abcdefghijklmnopqrstuvwxyz';
        }
        if ($options['uppercase']) {
            $chars .= $options['exclude_ambiguous'] ? 'ABCDEFGHJKLMNPQRSTUVWXYZ' : 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        if ($options['numbers']) {
            $chars .= $options['exclude_ambiguous'] ? '23456789' : '0123456789';
        }
        if ($options['symbols']) {
            $chars .= '!@#$%^&*()_+-=[]{}|;:,.<>?';
        }
        
        if (empty($chars)) {
            $chars = 'abcdefghijklmnopqrstuvwxyz';
        }
        
        $password = '';
        $charLength = strlen($chars);
        
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[random_int(0, $charLength - 1)];
        }
        
        return $password;
    }

    /**
     * Generate UUID v4
     */
    public function generateUUID(): string
    {
        $data = random_bytes(16);
        
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * Generate random number
     */
    public function generateNumber(int $min = 0, int $max = 100): int
    {
        return random_int($min, $max);
    }

    /**
     * Generate random decimal
     */
    public function generateDecimal(float $min = 0, float $max = 1, int $decimals = 2): float
    {
        $random = $min + mt_rand() / mt_getrandmax() * ($max - $min);
        return round($random, $decimals);
    }

    /**
     * Generate random letter
     */
    public function generateLetter(bool $uppercase = false): string
    {
        return $uppercase ? strtoupper($letter) : $letter;
    }

    /**
     * Generate random letters
     */
    public function generateLetters(int $count = 5, bool $uppercase = false): string
    {
        $letters = '';
        for ($i = 0; $i < $count; $i++) {
            $letters .= $this->generateLetter($uppercase);
        }
        return $letters;
    }

    /**
     * Generate random date
     */
    public function generateDate(string $startDate = '-1 year', string $endDate = 'now', string $format = 'Y-m-d'): string
    {
        $min = strtotime($startDate);
        $max = strtotime($endDate);
        
        $timestamp = random_int($min, $max);
        return date($format, $timestamp);
    }

    /**
     * Generate random month
     */
    public function generateMonth(bool $fullName = true): string
    {
        $month = random_int(1, 12);
        return $fullName ? date('F', mktime(0, 0, 0, $month, 1)) : date('M', mktime(0, 0, 0, $month, 1));
    }

    /**
     * Generate random IP address
     */
    public function generateIPAddress(string $version = 'v4'): string
    {
        if ($version === 'v6') {
            $hex = [];
            for ($i = 0; $i < 8; $i++) {
                $hex[] = dechex(random_int(0, 65535));
            }
            return implode(':', $hex);
        }
        
        return implode('.', [
            random_int(1, 255),
            random_int(0, 255),
            random_int(0, 255),
            random_int(1, 254)
        ]);
    }

    /**
     * Generate random MAC address
     */
    public function generateMACAddress(): string
    {
        $mac = [];
        for ($i = 0; $i < 6; $i++) {
            $mac[] = sprintf('%02X', random_int(0, 255));
        }
        return implode(':', $mac);
    }

    /**
     * Generate random choice from list
     */
    public function generateChoice(array $choices)
    {
        if (empty($choices)) {
            return null;
        }
        return $choices[array_rand($choices)];
    }

    /**
     * Generate multiple random choices
     */
    public function generateChoices(array $choices, int $count = 1): array
    {
        if (empty($choices) || $count <= 0) {
            return [];
        }
        
        $count = min($count, count($choices));
        $keys = array_rand($choices, $count);
        
        if ($count === 1) {
            return [$choices[$keys]];
        }
        
        $result = [];
        foreach ($keys as $key) {
            $result[] = $choices[$key];
        }
        return $result;
    }

    /**
     * Generate random hex color
     */
    public function generateHexColor(): string
    {
        return sprintf('#%06X', random_int(0, 0xFFFFFF));
    }

    /**
     * Generate random RGB color
     */
    public function generateRGBColor(): string
    {
        return sprintf('rgb(%d, %d, %d)', 
            random_int(0, 255),
            random_int(0, 255),
            random_int(0, 255)
        );
    }

    /**
     * Generate random phone number
     */
    public function generatePhoneNumber(string $format = 'US'): string
    {
        switch ($format) {
            case 'US':
                return sprintf('(%03d) %03d-%04d',
                    random_int(200, 999),
                    random_int(200, 999),
                    random_int(0, 9999)
                );
            case 'UK':
                return sprintf('07%d %d',
                    random_int(100, 999),
                    random_int(100000, 999999)
                );
            case 'International':
                return sprintf('+%d %d %d',
                    random_int(1, 99),
                    random_int(100, 999),
                    random_int(1000000, 9999999)
                );
            default:
                return sprintf('%010d', random_int(1000000000, 9999999999));
        }
    }

    /**
     * Generate lorem ipsum text
     */
    public function generateLoremIpsum(int $words = 50): string
    {
        $lorem = 'Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua Ut enim ad minim veniam quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur Excepteur sint occaecat cupidatat non proident sunt in culpa qui officia deserunt mollit anim id est laborum';
        
        $loremWords = explode(' ', $lorem);
        $result = [];
        
        for ($i = 0; $i < $words; $i++) {
            $result[] = $loremWords[array_rand($loremWords)];
        }
        
        $text = implode(' ', $result);
        return ucfirst(strtolower($text)) . '.';
    }

    /**
     * Generate random username
     */
    public function generateUsername(): string
    {
        $adjectives = ['happy', 'lucky', 'sunny', 'clever', 'bright', 'swift', 'quiet', 'brave', 'calm', 'eager'];
        $nouns = ['tiger', 'eagle', 'shark', 'wolf', 'bear', 'lion', 'hawk', 'fox', 'owl', 'dragon'];
        
        $adjective = $adjectives[array_rand($adjectives)];
        $noun = $nouns[array_rand($nouns)];
        $number = random_int(1, 999);
        
        return $adjective . ucfirst($noun) . $number;
    }

    /**
     * Generate random email
     */
    public function generateEmail(string $domain = 'example.com'): string
    {
        $username = strtolower($this->generateUsername());
        return $username . '@' . $domain;
    }
}