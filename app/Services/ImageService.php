<?php

namespace App\Services;

/**
 * Image Service
 * Handles image format conversions and ASCII art generation
 * Note: Since we can't actually process images in a web-based text tool,
 * these methods provide descriptive information about the conversion process
 */
class ImageService
{
    /**
     * Generate ASCII art from text
     */
    public function generateASCIIArt(string $text, string $style = 'basic'): string
    {
        $patterns = [
            'basic' => [
                'A' => " █▀█ \n █▀█ \n ▀ ▀ ",
                'B' => " ██  \n █▄█ \n ██▄ ",
                'C' => " ▄▀█ \n ▀▀▀ \n ▀▀▀ ",
                'D' => " ██  \n █ █ \n ██▄ ",
                'E' => " ███ \n ██▄ \n ███ ",
                'F' => " ███ \n ██▄ \n █   ",
                'G' => " ▄▀█ \n █▄█ \n ▀▀█ ",
                'H' => " █ █ \n ███ \n █ █ ",
                'I' => " ███ \n  █  \n ███ ",
                'J' => " ███ \n   █ \n ██▄ ",
                'K' => " █ █ \n ██  \n █ █ ",
                'L' => " █   \n █   \n ███ ",
                'M' => " █▄█ \n █▀█ \n █ █ ",
                'N' => " █▄█ \n █▀█ \n █ █ ",
                'O' => " ▄▀█ \n █ █ \n ▀▀▀ ",
                'P' => " ██▄ \n ██▀ \n █   ",
                'Q' => " ▄▀█ \n █▄█ \n ▀▀█ ",
                'R' => " ██▄ \n ██▀ \n █ █ ",
                'S' => " ▄▀▀ \n ▀▀▄ \n ▀▀▄ ",
                'T' => " ███ \n  █  \n  █  ",
                'U' => " █ █ \n █ █ \n ▀▀▀ ",
                'V' => " █ █ \n █ █ \n  █  ",
                'W' => " █ █ \n █▄█ \n ▀▀▀ ",
                'X' => " █ █ \n ▀▀▀ \n █ █ ",
                'Y' => " █ █ \n ▀▀▀ \n  █  ",
                'Z' => " ███ \n ▄▀  \n ███ ",
                ' ' => "     \n     \n     "
            ]
        ];

        $pattern = $patterns[$style] ?? $patterns['basic'];
        $text = strtoupper($text);
        $lines = ['', '', ''];
        
        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            $art = $pattern[$char] ?? $pattern[' '];
            $charLines = explode("\n", $art);
            
            for ($j = 0; $j < 3; $j++) {
                $lines[$j] .= $charLines[$j] . ' ';
            }
        }
        
        return implode("\n", $lines);
    }

    /**
     * Generate small ASCII art
     */
    public function generateSmallASCII(string $text): string
    {
        $patterns = [
            'A' => '█▀▄', 'B' => '█▀▄', 'C' => '▄▀▀', 'D' => '█▀▄', 'E' => '█▀▀',
            'F' => '█▀▀', 'G' => '▄▀▀', 'H' => '█ █', 'I' => '█', 'J' => '  █',
            'K' => '█ █', 'L' => '█  ', 'M' => '█▄█', 'N' => '█▄█', 'O' => '▄▀▄',
            'P' => '█▀▄', 'Q' => '▄▀▄', 'R' => '█▀▄', 'S' => '▄▀▀', 'T' => '▀█▀',
            'U' => '█ █', 'V' => '█ █', 'W' => '█ █', 'X' => '█ █', 'Y' => '█ █',
            'Z' => '▀▀▀', ' ' => ' '
        ];
        
        $result = '';
        for ($i = 0; $i < strlen($text); $i++) {
            $char = strtoupper($text[$i]);
            $result .= $patterns[$char] ?? $char;
        }
        
        return $result;
    }

    /**
     * Image to text converter (descriptive)
     */
    public function imageToText(string $imagePath): string
    {
        return "Image to Text Conversion:\n\n" .
               "To convert an image to text, you would typically use OCR (Optical Character Recognition) software.\n\n" .
               "Popular OCR tools include:\n" .
               "• Tesseract OCR\n" .
               "• Google Cloud Vision API\n" .
               "• Amazon Textract\n" .
               "• Adobe Acrobat\n\n" .
               "Upload your image to one of these services to extract text content.";
    }

    /**
     * JPG to PNG converter (descriptive)
     */
    public function jpgToPng(): string
    {
        return "JPG to PNG Conversion:\n\n" .
               "To convert JPG images to PNG format:\n\n" .
               "1. Upload your JPG image\n" .
               "2. Choose PNG as output format\n" .
               "3. Adjust quality settings if needed\n" .
               "4. Download the converted PNG file\n\n" .
               "PNG format supports transparency and lossless compression,\n" .
               "making it ideal for images with sharp edges and text.\n\n" .
               "Recommended tools:\n" .
               "• Online converters (CloudConvert, Convertio)\n" .
               "• Desktop software (GIMP, Photoshop)\n" .
               "• Command line (ImageMagick)";
    }

    /**
     * PNG to JPG converter (descriptive)
     */
    public function pngToJpg(): string
    {
        return "PNG to JPG Conversion:\n\n" .
               "To convert PNG images to JPG format:\n\n" .
               "1. Upload your PNG image\n" .
               "2. Choose JPG as output format\n" .
               "3. Set compression quality (70-90% recommended)\n" .
               "4. Download the converted JPG file\n\n" .
               "Note: JPG doesn't support transparency. Transparent areas\n" .
               "will be filled with white or another background color.\n\n" .
               "JPG is better for photographs with many colors,\n" .
               "while PNG is better for images with few colors or transparency.";
    }

    /**
     * WebP converter (descriptive)
     */
    public function webPConverter(string $fromFormat, string $toFormat): string
    {
        return "WebP Format Conversion:\n\n" .
               "Converting {$fromFormat} to {$toFormat}:\n\n" .
               "WebP is a modern image format that provides:\n" .
               "• Superior compression (25-50% smaller files)\n" .
               "• Support for transparency\n" .
               "• Animation support\n" .
               "• Wide browser support\n\n" .
               "Conversion tools:\n" .
               "• Google's cwebp/dwebp command-line tools\n" .
               "• Online converters (Squoosh, CloudConvert)\n" .
               "• Image editing software with WebP plugins\n\n" .
               "WebP is ideal for web optimization and faster loading times.";
    }

    /**
     * SVG to PNG converter (descriptive)
     */
    public function svgToPng(): string
    {
        return "SVG to PNG Conversion:\n\n" .
               "To convert SVG (vector) to PNG (raster):\n\n" .
               "1. Set desired output dimensions\n" .
               "2. Choose resolution (DPI)\n" .
               "3. Select background color (transparent/solid)\n" .
               "4. Export as PNG\n\n" .
               "Key considerations:\n" .
               "• SVG is scalable, PNG has fixed dimensions\n" .
               "• Higher DPI = larger file size but better quality\n" .
               "• PNG supports transparency like SVG\n\n" .
               "Recommended tools:\n" .
               "• Inkscape (free vector editor)\n" .
               "• Adobe Illustrator\n" .
               "• Online SVG to PNG converters\n" .
               "• Browser developer tools";
    }

    /**
     * Generate text banner
     */
    public function generateBanner(string $text, string $style = 'double'): string
    {
        $styles = [
            'single' => ['─', '│', '┌', '┐', '└', '┘'],
            'double' => ['═', '║', '╔', '╗', '╚', '╝'],
            'thick' => ['━', '┃', '┏', '┓', '┗', '┛'],
            'round' => ['─', '│', '╭', '╮', '╰', '╯']
        ];
        
        $chars = $styles[$style] ?? $styles['double'];
        [$h, $v, $tl, $tr, $bl, $br] = $chars;
        
        $width = strlen($text) + 4;
        $top = $tl . str_repeat($h, $width - 2) . $tr;
        $middle = $v . ' ' . $text . ' ' . $v;
        $bottom = $bl . str_repeat($h, $width - 2) . $br;
        
        return $top . "\n" . $middle . "\n" . $bottom;
    }

    /**
     * Generate block text
     */
    public function generateBlockText(string $text): string
    {
        $blocks = [
            'A' => ["██████", "██  ██", "██████", "██  ██", "██  ██"],
            'B' => ["██████", "██  ██", "██████", "██  ██", "██████"],
            'C' => ["██████", "██    ", "██    ", "██    ", "██████"],
            'D' => ["██████", "██  ██", "██  ██", "██  ██", "██████"],
            'E' => ["██████", "██    ", "██████", "██    ", "██████"],
            'F' => ["██████", "██    ", "██████", "██    ", "██    "],
            'G' => ["██████", "██    ", "██ ███", "██  ██", "██████"],
            'H' => ["██  ██", "██  ██", "██████", "██  ██", "██  ██"],
            'I' => ["██████", "  ██  ", "  ██  ", "  ██  ", "██████"],
            'J' => ["██████", "    ██", "    ██", "██  ██", "██████"],
            'K' => ["██  ██", "██ ██ ", "████  ", "██ ██ ", "██  ██"],
            'L' => ["██    ", "██    ", "██    ", "██    ", "██████"],
            'M' => ["██████", "██████", "██  ██", "██  ██", "██  ██"],
            'N' => ["██████", "██  ██", "██  ██", "██  ██", "██  ██"],
            'O' => ["██████", "██  ██", "██  ██", "██  ██", "██████"],
            'P' => ["██████", "██  ██", "██████", "██    ", "██    "],
            'Q' => ["██████", "██  ██", "██ ███", "██  ██", "██████"],
            'R' => ["██████", "██  ██", "██████", "██  ██", "██  ██"],
            'S' => ["██████", "██    ", "██████", "    ██", "██████"],
            'T' => ["██████", "  ██  ", "  ██  ", "  ██  ", "  ██  "],
            'U' => ["██  ██", "██  ██", "██  ██", "██  ██", "██████"],
            'V' => ["██  ██", "██  ██", "██  ██", " ████ ", "  ██  "],
            'W' => ["██  ██", "██  ██", "██  ██", "██████", "██████"],
            'X' => ["██  ██", " ████ ", "  ██  ", " ████ ", "██  ██"],
            'Y' => ["██  ██", " ████ ", "  ██  ", "  ██  ", "  ██  "],
            'Z' => ["██████", "   ██ ", "  ██  ", " ██   ", "██████"],
            ' ' => ["      ", "      ", "      ", "      ", "      "]
        ];
        
        $text = strtoupper($text);
        $lines = ["", "", "", "", ""];
        
        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            $block = $blocks[$char] ?? $blocks[' '];
            
            for ($j = 0; $j < 5; $j++) {
                $lines[$j] .= $block[$j] . "  ";
            }
        }
        
        return implode("\n", $lines);
    }
}