<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\TransformationService;
use App\Livewire\UniversalConverter;

class TransformationServiceTest extends TestCase
{
    protected $transformationService;
    protected $universalConverter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->transformationService = new TransformationService();
        $this->universalConverter = new UniversalConverter();
    }

    /**
     * @dataProvider formatProvider
     */
    public function test_all_formats_return_a_string($format)
    {
        $inputText = 'Hello World 123! This is a test.';
        $outputText = $this->transformationService->transform($inputText, $format, []);
        $this->assertIsString($outputText);
    }

    public static function formatProvider()
    {
        $universalConverter = new UniversalConverter();
        $formats = [];
        foreach ($universalConverter->formats as $category => $categoryFormats) {
            foreach ($categoryFormats as $key => $name) {
                $formats[$name] = [$key];
            }
        }
        return $formats;
    }
}
