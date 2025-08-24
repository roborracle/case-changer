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
    
    protected $transformationService;
    protected $textEffectsService;
    protected $codeDataService;
    protected $generatorService;
    protected $textAnalysisService;

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

    public function boot()
    {
        $this->transformationService = app(TransformationService::class);
        $this->textEffectsService = app(TextEffectsService::class);
        $this->codeDataService = app(CodeDataService::class);
        $this->generatorService = app(GeneratorService::class);
        $this->textAnalysisService = app(TextAnalysisService::class);
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
                return $this->textEffectsService->toBold($text);
            case 'italic':
                return $this->textEffectsService->toItalic($text);
            case 'strikethrough':
                return $this->textEffectsService->toStrikethrough($text);
            case 'underline':
                return $this->textEffectsService->toUnderline($text);
            case 'bubble':
                return $this->textEffectsService->toBubble($text);
            case 'square':
                return $this->textEffectsService->toSquare($text);
            case 'upside-down':
                return $this->textEffectsService->toUpsideDown($text);
            case 'wide':
                return $this->textEffectsService->toWide($text);
            case 'mirror':
                return $this->textEffectsService->toMirror($text);
            case 'zalgo':
                $intensity = $this->options['intensity'] ?? 5;
                return $this->textEffectsService->toZalgo($text, $intensity);
            case 'cursed':
                return $this->textEffectsService->toCursed($text);
            case 'invisible':
                return $this->textEffectsService->toInvisible($text);
            case 'superscript':
                return $this->textEffectsService->toSuperscript($text);
            case 'subscript':
                return $this->textEffectsService->toSubscript($text);
            default:
                return $text;
        }
    }

    private function transformCodeData($text)
    {
        switch ($this->tool) {
            case 'binary':
                return $this->codeDataService->toBinary($text);
            case 'from-binary':
                return $this->codeDataService->fromBinary($text);
            case 'hex':
                return $this->codeDataService->toHex($text);
            case 'from-hex':
                return $this->codeDataService->fromHex($text);
            case 'morse':
                return $this->codeDataService->toMorse($text);
            case 'caesar':
                $shift = $this->options['shift'] ?? 3;
                return $this->codeDataService->caesarCipher($text, $shift);
            case 'md5':
                return $this->codeDataService->toMD5($text);
            case 'sha256':
                return $this->codeDataService->toSHA256($text);
            case 'slug':
                return $this->codeDataService->toSlug($text);
            case 'json-format':
                return $this->codeDataService->formatJSON($text);
            case 'json-minify':
                return $this->codeDataService->minifyJSON($text);
            case 'csv-to-json':
                return $this->codeDataService->csvToJSON($text);
            case 'css-format':
                return $this->codeDataService->formatCSS($text);
            case 'css-minify':
                return $this->codeDataService->minifyCSS($text);
            case 'html-format':
                return $this->codeDataService->formatHTML($text);
            case 'html-minify':
                return $this->codeDataService->minifyHTML($text);
            case 'js-format':
                return $this->codeDataService->formatJavaScript($text);
            case 'xml-format':
                return $this->codeDataService->formatXML($text);
            case 'yaml-format':
                return $this->codeDataService->formatYAML($text);
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
                return $this->generatorService->generatePassword($length, $this->options);
            case 'uuid':
                return $this->generatorService->generateUUID();
            case 'number':
                $min = $this->options['min'] ?? 0;
                $max = $this->options['max'] ?? 100;
                return (string) $this->generatorService->generateNumber($min, $max);
            case 'letter':
                $count = $this->options['count'] ?? 5;
                $uppercase = $this->options['uppercase'] ?? false;
                return $this->generatorService->generateLetters($count, $uppercase);
            case 'date':
                $format = $this->options['format'] ?? 'Y-m-d';
                return $this->generatorService->generateDate('-1 year', 'now', $format);
            case 'month':
                $fullName = $this->options['full_name'] ?? true;
                return $this->generatorService->generateMonth($fullName);
            case 'ip-address':
                $version = $this->options['version'] ?? 'v4';
                return $this->generatorService->generateIPAddress($version);
            case 'mac-address':
                return $this->generatorService->generateMACAddress();
            case 'hex-color':
                return $this->generatorService->generateHexColor();
            case 'rgb-color':
                return $this->generatorService->generateRGBColor();
            case 'phone':
                $format = $this->options['format'] ?? 'US';
                return $this->generatorService->generatePhoneNumber($format);
            case 'lorem-ipsum':
                $words = $this->options['words'] ?? 50;
                return $this->generatorService->generateLoremIpsum($words);
            case 'username':
                return $this->generatorService->generateUsername();
            case 'email':
                $domain = $this->options['domain'] ?? 'example.com';
                return $this->generatorService->generateEmail($domain);
            default:
                return '';
        }
    }

    private function analyzeText($text)
    {
        switch ($this->tool) {
            case 'word-count':
                return 'Words: ' . $this->textAnalysisService->countWords($text);
            case 'character-count':
                $withSpaces = $this->textAnalysisService->countCharacters($text, true);
                $withoutSpaces = $this->textAnalysisService->countCharacters($text, false);
                return "Characters: $withSpaces (with spaces), $withoutSpaces (without spaces)";
            case 'sentence-count':
                return 'Sentences: ' . $this->textAnalysisService->countSentences($text);
            case 'word-frequency':
                $frequency = $this->textAnalysisService->getWordFrequency($text, 10);
                return $this->formatWordFrequency($frequency);
            case 'remove-duplicates':
                return $this->textAnalysisService->removeDuplicateLines($text);
            case 'remove-duplicate-words':
                return $this->textAnalysisService->removeDuplicateWords($text);
            case 'find-duplicates':
                $duplicates = $this->textAnalysisService->findDuplicateWords($text);
                return $this->formatDuplicates($duplicates);
            case 'remove-line-breaks':
                return $this->textAnalysisService->removeLineBreaks($text);
            case 'remove-extra-spaces':
                return $this->textAnalysisService->removeExtraSpaces($text);
            case 'remove-punctuation':
                return $this->textAnalysisService->removePunctuation($text);
            case 'sort-words':
                return $this->textAnalysisService->sortWords($text);
            case 'sort-lines':
                return $this->textAnalysisService->sortLines($text);
            case 'shuffle-words':
                return $this->textAnalysisService->shuffleWords($text);
            case 'repeat-text':
                $times = $this->options['times'] ?? 3;
                $separator = $this->options['separator'] ?? ' ';
                return $this->textAnalysisService->repeatText($text, $times, $separator);
            case 'nato-phonetic':
                return $this->textAnalysisService->toNATOPhonetic($text);
            case 'pig-latin':
                return $this->textAnalysisService->toPigLatin($text);
            case 'extract-urls':
                $urls = $this->textAnalysisService->extractURLs($text);
                return implode("\n", $urls);
            case 'extract-emails':
                $emails = $this->textAnalysisService->extractEmails($text);
                return implode("\n", $emails);
            default:
                return $text;
        }
    }

    private function transformCase($text)
    {
        switch ($this->tool) {
            case 'uppercase':
                return $this->transformationService->toUpperCase($text);
            case 'lowercase':
                return $this->transformationService->toLowerCase($text);
            case 'title-case':
                return $this->transformationService->toTitleCase($text);
            case 'sentence-case':
                return $this->transformationService->toSentenceCase($text);
            case 'capitalize-words':
                return $this->transformationService->toCapitalizedWords($text);
            case 'alternating-case':
                return $this->transformationService->toAlternatingCase($text);
            case 'inverse-case':
                return $this->transformationService->toInverseCase($text);
            default:
                return $text;
        }
    }

    private function transformDeveloper($text)
    {
        switch ($this->tool) {
            case 'camel-case':
                return $this->transformationService->toCamelCase($text);
            case 'pascal-case':
                return $this->transformationService->toPascalCase($text);
            case 'snake-case':
                return $this->transformationService->toSnakeCase($text);
            case 'kebab-case':
                return $this->transformationService->toKebabCase($text);
            case 'constant-case':
                return $this->transformationService->toConstantCase($text);
            case 'dot-case':
                return $this->transformationService->toDotCase($text);
            case 'path-case':
                return $this->transformationService->toPathCase($text);
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