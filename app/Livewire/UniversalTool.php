<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\TransformationService;
use App\Services\TextEffectsService;
use App\Services\CodeDataService;
use App\Services\GeneratorService;
use App\Services\TextAnalysisService;

class UniversalTool extends Component
{
    public $tool = '';
    public $category = '';
    public $input = '';
    public $output = '';
    public $options = [];
    public $toolInfo = [];
    
    // Services are resolved via getter methods to avoid Livewire serialization issues

    public function mount($tool, $category)
    {
        $this->tool = $tool;
        $this->category = $category;
        $this->loadToolInfo();
        
        // Set default input based on tool type
        if ($this->category === 'generators') {
            $this->generateOutput();
        } else {
            $this->input = $this->toolInfo['example_input'] ?? 'Enter your text here';
        }
    }

    protected function getTransformationService(): TransformationService
    {
        return app(TransformationService::class);
    }

    protected function getTextEffectsService(): TextEffectsService
    {
        return app(TextEffectsService::class);
    }

    protected function getCodeDataService(): CodeDataService
    {
        return app(CodeDataService::class);
    }

    protected function getGeneratorService(): GeneratorService
    {
        return app(GeneratorService::class);
    }

    protected function getTextAnalysisService(): TextAnalysisService
    {
        return app(TextAnalysisService::class);
    }

    public function updatedInput()
    {
        $this->processTransformation();
    }

    public function updatedOptions()
    {
        $this->processTransformation();
    }

    public function processTransformation()
    {
        if (empty($this->input) && $this->category !== 'generators') {
            $this->output = '';
            return;
        }

        try {
            $this->output = $this->transform($this->input);
        } catch (\Exception $e) {
            $this->output = 'Error processing text: ' . $e->getMessage();
        }
    }

    public function generateOutput()
    {
        if ($this->category !== 'generators') {
            return;
        }

        try {
            $this->output = $this->transform('');
        } catch (\Exception $e) {
            $this->output = 'Error generating output: ' . $e->getMessage();
        }
    }

    private function transform($text)
    {
        switch ($this->category) {
            case 'text-effects':
                return $this->transformTextEffect($text);
            case 'code-data':
                return $this->transformCodeData($text);
            case 'generators':
                return $this->generateRandom();
            case 'text-analysis':
                return $this->analyzeText($text);
            case 'case-conversions':
                return $this->transformCase($text);
            case 'developer-formats':
                return $this->transformDeveloper($text);
            default:
                return $this->transformGeneral($text);
        }
    }

    private function transformTextEffect($text)
    {
        switch ($this->tool) {
            case 'bold':
                return $this->getTextEffectsService()->toBold($text);
            case 'italic':
                return $this->getTextEffectsService()->toItalic($text);
            case 'strikethrough':
                return $this->getTextEffectsService()->toStrikethrough($text);
            case 'underline':
                return $this->getTextEffectsService()->toUnderline($text);
            case 'bubble':
                return $this->getTextEffectsService()->toBubble($text);
            case 'square':
                return $this->getTextEffectsService()->toSquare($text);
            case 'upside-down':
                return $this->getTextEffectsService()->toUpsideDown($text);
            case 'wide':
                return $this->getTextEffectsService()->toWide($text);
            case 'mirror':
                return $this->getTextEffectsService()->toMirror($text);
            case 'zalgo':
                $intensity = $this->options['intensity'] ?? 5;
                return $this->getTextEffectsService()->toZalgo($text, $intensity);
            case 'cursed':
                return $this->getTextEffectsService()->toCursed($text);
            case 'invisible':
                return $this->getTextEffectsService()->toInvisible($text);
            case 'superscript':
                return $this->getTextEffectsService()->toSuperscript($text);
            case 'subscript':
                return $this->getTextEffectsService()->toSubscript($text);
            default:
                return $text;
        }
    }

    private function transformCodeData($text)
    {
        switch ($this->tool) {
            case 'binary':
                return $this->getCodeDataService()->toBinary($text);
            case 'from-binary':
                return $this->getCodeDataService()->fromBinary($text);
            case 'hex':
                return $this->getCodeDataService()->toHex($text);
            case 'from-hex':
                return $this->getCodeDataService()->fromHex($text);
            case 'morse':
                return $this->getCodeDataService()->toMorse($text);
            case 'caesar':
                $shift = $this->options['shift'] ?? 3;
                return $this->getCodeDataService()->caesarCipher($text, $shift);
            case 'md5':
                return $this->getCodeDataService()->toMD5($text);
            case 'sha256':
                return $this->getCodeDataService()->toSHA256($text);
            case 'slug':
                return $this->getCodeDataService()->toSlug($text);
            case 'json-format':
                return $this->getCodeDataService()->formatJSON($text);
            case 'json-minify':
                return $this->getCodeDataService()->minifyJSON($text);
            case 'csv-to-json':
                return $this->getCodeDataService()->csvToJSON($text);
            case 'css-format':
                return $this->getCodeDataService()->formatCSS($text);
            case 'css-minify':
                return $this->getCodeDataService()->minifyCSS($text);
            case 'html-format':
                return $this->getCodeDataService()->formatHTML($text);
            case 'html-minify':
                return $this->getCodeDataService()->minifyHTML($text);
            case 'js-format':
                return $this->getCodeDataService()->formatJavaScript($text);
            case 'xml-format':
                return $this->getCodeDataService()->formatXML($text);
            case 'yaml-format':
                return $this->getCodeDataService()->formatYAML($text);
            case 'base64-encode':
                return base64_encode($text);
            case 'base64-decode':
                return base64_decode($text);
            case 'url-encode':
                return urlencode($text);
            case 'url-decode':
                return urldecode($text);
            case 'rot13':
                return str_rot13($text);
            default:
                return $text;
        }
    }

    private function generateRandom()
    {
        switch ($this->tool) {
            case 'password':
                $length = $this->options['length'] ?? 16;
                return $this->getGeneratorService()->generatePassword($length, $this->options);
            case 'uuid':
                return $this->getGeneratorService()->generateUUID();
            case 'number':
                $min = $this->options['min'] ?? 0;
                $max = $this->options['max'] ?? 100;
                return (string) $this->getGeneratorService()->generateNumber($min, $max);
            case 'letter':
                $count = $this->options['count'] ?? 5;
                $uppercase = $this->options['uppercase'] ?? false;
                return $this->getGeneratorService()->generateLetters($count, $uppercase);
            case 'date':
                $format = $this->options['format'] ?? 'Y-m-d';
                return $this->getGeneratorService()->generateDate('-1 year', 'now', $format);
            case 'month':
                $fullName = $this->options['full_name'] ?? true;
                return $this->getGeneratorService()->generateMonth($fullName);
            case 'ip-address':
                $version = $this->options['version'] ?? 'v4';
                return $this->getGeneratorService()->generateIPAddress($version);
            case 'mac-address':
                return $this->getGeneratorService()->generateMACAddress();
            case 'hex-color':
                return $this->getGeneratorService()->generateHexColor();
            case 'rgb-color':
                return $this->getGeneratorService()->generateRGBColor();
            case 'phone':
                $format = $this->options['format'] ?? 'US';
                return $this->getGeneratorService()->generatePhoneNumber($format);
            case 'lorem-ipsum':
                $words = $this->options['words'] ?? 50;
                return $this->getGeneratorService()->generateLoremIpsum($words);
            case 'username':
                return $this->getGeneratorService()->generateUsername();
            case 'email':
                $domain = $this->options['domain'] ?? 'example.com';
                return $this->getGeneratorService()->generateEmail($domain);
            default:
                return '';
        }
    }

    private function analyzeText($text)
    {
        switch ($this->tool) {
            case 'word-count':
                return 'Words: ' . $this->getTextAnalysisService()->countWords($text);
            case 'character-count':
                $withSpaces = $this->getTextAnalysisService()->countCharacters($text, true);
                $withoutSpaces = $this->getTextAnalysisService()->countCharacters($text, false);
                return "Characters: $withSpaces (with spaces), $withoutSpaces (without spaces)";
            case 'sentence-count':
                return 'Sentences: ' . $this->getTextAnalysisService()->countSentences($text);
            case 'word-frequency':
                $frequency = $this->getTextAnalysisService()->getWordFrequency($text, 10);
                return $this->formatWordFrequency($frequency);
            case 'remove-duplicates':
                return $this->getTextAnalysisService()->removeDuplicateLines($text);
            case 'remove-duplicate-words':
                return $this->getTextAnalysisService()->removeDuplicateWords($text);
            case 'find-duplicates':
                $duplicates = $this->getTextAnalysisService()->findDuplicateWords($text);
                return $this->formatDuplicates($duplicates);
            case 'remove-line-breaks':
                return $this->getTextAnalysisService()->removeLineBreaks($text);
            case 'remove-extra-spaces':
                return $this->getTextAnalysisService()->removeExtraSpaces($text);
            case 'remove-punctuation':
                return $this->getTextAnalysisService()->removePunctuation($text);
            case 'sort-words':
                return $this->getTextAnalysisService()->sortWords($text);
            case 'sort-lines':
                return $this->getTextAnalysisService()->sortLines($text);
            case 'shuffle-words':
                return $this->getTextAnalysisService()->shuffleWords($text);
            case 'repeat-text':
                $times = $this->options['times'] ?? 3;
                $separator = $this->options['separator'] ?? ' ';
                return $this->getTextAnalysisService()->repeatText($text, $times, $separator);
            case 'nato-phonetic':
                return $this->getTextAnalysisService()->toNATOPhonetic($text);
            case 'pig-latin':
                return $this->getTextAnalysisService()->toPigLatin($text);
            case 'extract-urls':
                $urls = $this->getTextAnalysisService()->extractURLs($text);
                return implode("\n", $urls);
            case 'extract-emails':
                $emails = $this->getTextAnalysisService()->extractEmails($text);
                return implode("\n", $emails);
            default:
                return $text;
        }
    }

    private function transformCase($text)
    {
        switch ($this->tool) {
            case 'uppercase':
                return $this->getTransformationService()->toUpperCase($text);
            case 'lowercase':
                return $this->getTransformationService()->toLowerCase($text);
            case 'title-case':
                return $this->getTransformationService()->toTitleCase($text);
            case 'sentence-case':
                return $this->getTransformationService()->toSentenceCase($text);
            case 'capitalize-words':
                return $this->getTransformationService()->toCapitalizedWords($text);
            case 'alternating-case':
                return $this->getTransformationService()->toAlternatingCase($text);
            case 'inverse-case':
                return $this->getTransformationService()->toInverseCase($text);
            default:
                return $text;
        }
    }

    private function transformDeveloper($text)
    {
        switch ($this->tool) {
            case 'camel-case':
                return $this->getTransformationService()->toCamelCase($text);
            case 'pascal-case':
                return $this->getTransformationService()->toPascalCase($text);
            case 'snake-case':
                return $this->getTransformationService()->toSnakeCase($text);
            case 'kebab-case':
                return $this->getTransformationService()->toKebabCase($text);
            case 'constant-case':
                return $this->getTransformationService()->toConstantCase($text);
            case 'dot-case':
                return $this->getTransformationService()->toDotCase($text);
            case 'path-case':
                return $this->getTransformationService()->toPathCase($text);
            default:
                return $text;
        }
    }

    private function transformGeneral($text)
    {
        // Handle any other transformation types
        return $text;
    }

    private function formatWordFrequency($frequency)
    {
        $result = "Word Frequency Analysis:\n\n";
        foreach ($frequency as $word => $count) {
            $result .= "$word: $count occurrence" . ($count > 1 ? 's' : '') . "\n";
        }
        return $result;
    }

    private function formatDuplicates($duplicates)
    {
        if (empty($duplicates)) {
            return "No duplicate words found.";
        }
        
        $result = "Duplicate Words Found:\n\n";
        foreach ($duplicates as $word => $count) {
            $result .= "$word: appears $count times\n";
        }
        return $result;
    }

    private function loadToolInfo()
    {
        // Load tool-specific information and examples
        $toolData = config("tools.{$this->category}.{$this->tool}", []);
        
        $this->toolInfo = array_merge([
            'name' => ucwords(str_replace('-', ' ', $this->tool)),
            'description' => '',
            'example_input' => 'Hello World',
            'example_output' => '',
            'features' => [],
            'options' => []
        ], $toolData);
    }

    public function copyToClipboard()
    {
        $this->dispatch('copied');
    }

    public function downloadText()
    {
        $filename = $this->tool . '-output.txt';
        
        return response()->streamDownload(function () {
            echo $this->output;
        }, $filename);
    }

    public function clearText()
    {
        $this->input = '';
        $this->output = '';
    }

    public function render()
    {
        return view('livewire.universal-tool', [
            'toolInfo' => $this->toolInfo
        ]);
    }
}