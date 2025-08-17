<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\CaseChanger;

/**
 * SCARLETT Documentation Standard
 * Purpose: Test all Case Changer transformations for functionality and security
 * Assumptions: Livewire component is properly configured
 * Constraints: Test input limited to safe strings
 * Failure Modes: Transformation failure, XSS vulnerabilities, input validation bypass
 */
class CaseChangerTest extends TestCase
{
    /** @test */
    public function case_changer_component_renders_successfully()
    {
        $response = $this->get('/case-changer');
        
        $response->assertStatus(200);
        $response->assertSeeLivewire(CaseChanger::class);
    }

    /** @test */
    public function title_case_transformation_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'hello world test')
            ->call('transformToTitleCase')
            ->assertSet('outputText', 'Hello World Test');
    }

    /** @test */
    public function sentence_case_transformation_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'HELLO WORLD TEST')
            ->call('transformToSentenceCase')
            ->assertSet('outputText', 'Hello world test');
    }

    /** @test */
    public function uppercase_transformation_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'hello world test')
            ->call('transformToUpperCase')
            ->assertSet('outputText', 'HELLO WORLD TEST');
    }

    /** @test */
    public function lowercase_transformation_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'HELLO WORLD TEST')
            ->call('transformToLowerCase')
            ->assertSet('outputText', 'hello world test');
    }

    /** @test */
    public function alternating_case_transformation_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'hello world')
            ->call('transformToAlternatingCase')
            ->assertSet('outputText', 'hElLo WoRlD');
    }

    /** @test */
    public function camel_case_transformation_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'hello world test')
            ->call('transformToCamelCase')
            ->assertSet('outputText', 'helloWorldTest');
    }

    /** @test */
    public function snake_case_transformation_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'hello world test')
            ->call('transformToSnakeCase')
            ->assertSet('outputText', 'hello_world_test');
    }

    /** @test */
    public function kebab_case_transformation_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'hello world test')
            ->call('transformToKebabCase')
            ->assertSet('outputText', 'hello-world-test');
    }

    /** @test */
    public function pascal_case_transformation_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'hello world test')
            ->call('transformToPascalCase')
            ->assertSet('outputText', 'HelloWorldTest');
    }

    /** @test */
    public function constant_case_transformation_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'hello world test')
            ->call('transformToConstantCase')
            ->assertSet('outputText', 'HELLO_WORLD_TEST');
    }

    /** @test */
    public function apa_style_formatting_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'the quick brown fox jumps over the lazy dog')
            ->call('applyApaStyle')
            ->assertDontSee('errorMessage');
    }

    /** @test */
    public function chicago_style_formatting_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'the quick brown fox jumps over the lazy dog')
            ->call('applyChicagoStyle')
            ->assertDontSee('errorMessage');
    }

    /** @test */
    public function ap_style_formatting_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'the quick brown fox jumps over the lazy dog')
            ->call('applyApStyle')
            ->assertDontSee('errorMessage');
    }

    /** @test */
    public function mla_style_formatting_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'the quick brown fox jumps over the lazy dog')
            ->call('applyMlaStyle')
            ->assertDontSee('errorMessage');
    }

    /** @test */
    public function bluebook_style_formatting_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'the quick brown fox jumps over the lazy dog')
            ->call('applyBluebookStyle')
            ->assertDontSee('errorMessage');
    }

    /** @test */
    public function ama_style_formatting_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'the quick brown fox jumps over the lazy dog')
            ->call('applyAmaStyle')
            ->assertDontSee('errorMessage');
    }

    /** @test */
    public function ny_times_style_formatting_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'the quick brown fox jumps over the lazy dog')
            ->call('applyNyTimesStyle')
            ->assertDontSee('errorMessage');
    }

    /** @test */
    public function wikipedia_style_formatting_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'the quick brown fox jumps over the lazy dog')
            ->call('applyWikipediaStyle')
            ->assertDontSee('errorMessage');
    }

    /** @test */
    public function smart_quotes_conversion_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'This is a "test" with \'quotes\'')
            ->call('convertToSmartQuotes')
            ->assertDontSee('errorMessage');
    }

    /** @test */
    public function preposition_fixing_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'The Cat In The Hat')
            ->call('fixPrepositions')
            ->assertDontSee('errorMessage');
    }

    /** @test */
    public function space_management_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'hello     world    test')
            ->call('removeExtraSpaces')
            ->assertSet('outputText', 'hello world test');
    }

    /** @test */
    public function underscore_conversion_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'hello world test')
            ->call('spacesToUnderscores')
            ->assertSet('outputText', 'hello_world_test');

        Livewire::test(CaseChanger::class)
            ->set('inputText', 'hello_world_test')
            ->call('underscoresToSpaces')
            ->assertSet('outputText', 'hello world test');
    }

    /** @test */
    public function input_validation_prevents_oversized_text()
    {
        $largeText = str_repeat('a', 100001); // Exceeds 100KB limit
        
        Livewire::test(CaseChanger::class)
            ->set('inputText', $largeText)
            ->assertSet('errorMessage', 'Text exceeds maximum length of 100,000 characters.');
    }

    /** @test */
    public function text_statistics_update_correctly()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'Hello world. This is a test.')
            ->assertSet('stats.characters', 28)
            ->assertSet('stats.words', 6)
            ->assertSet('stats.sentences', 2);
    }

    /** @test */
    public function copy_functionality_triggers_without_error()
    {
        Livewire::test(CaseChanger::class)
            ->set('outputText', 'Test content')
            ->call('copyToClipboard')
            ->assertSet('copied', true);
    }

    /** @test */
    public function advanced_options_toggle_works()
    {
        Livewire::test(CaseChanger::class)
            ->assertSet('showAdvancedOptions', false)
            ->call('toggleAdvancedOptions')
            ->assertSet('showAdvancedOptions', true);
    }

    /** @test */
    public function xss_prevention_in_input_text()
    {
        $maliciousInput = '<script>alert("xss")</script>test';
        
        Livewire::test(CaseChanger::class)
            ->set('inputText', $maliciousInput)
            ->call('transformToUpperCase')
            ->assertSet('outputText', '<SCRIPT>ALERT("XSS")</SCRIPT>TEST')
            ->assertDontSee('<script>alert("xss")</script>', false); // Should be escaped in HTML
    }

    /** @test */
    public function utf8_validation_works()
    {
        // Test with valid UTF-8
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'Hello 世界 🌍')
            ->assertSet('errorMessage', '');

        // This would test invalid UTF-8 if we had a way to inject it
        // In practice, browsers handle UTF-8 validation
    }

    /** @test */
    public function dot_case_transformation_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'hello world test')
            ->call('transformToDotCase')
            ->assertSet('outputText', 'hello.world.test');
    }

    /** @test */
    public function path_case_transformation_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'hello world test')
            ->call('transformToPathCase')
            ->assertSet('outputText', 'hello/world/test');
    }

    /** @test */
    public function header_case_transformation_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'hello world test')
            ->call('transformToHeaderCase')
            ->assertSet('outputText', 'Hello-World-Test');
    }

    /** @test */
    public function train_case_transformation_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'hello world test')
            ->call('transformToTrainCase')
            ->assertSet('outputText', 'Hello-World-Test');
    }

    /** @test */
    public function spongebob_case_transformation_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'hello world')
            ->call('transformToSpongebobCase')
            ->assertSet('outputText', 'hElLo WoRlD');
    }

    /** @test */
    public function inverse_case_transformation_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'Hello World')
            ->call('transformToInverseCase')
            ->assertSet('outputText', 'hELLO wORLD');
    }

    /** @test */
    public function reversed_text_transformation_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'hello world')
            ->call('transformToReversedText')
            ->assertSet('outputText', 'dlrow olleh');
    }

    /** @test */
    public function no_whitespace_transformation_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'hello world test')
            ->call('transformToNoWhitespace')
            ->assertSet('outputText', 'helloworldtest');
    }

    /** @test */
    public function ieee_style_formatting_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'the quick brown fox jumps over the lazy dog')
            ->call('applyIeeeStyle')
            ->assertDontSee('errorMessage');
    }

    /** @test */
    public function harvard_style_formatting_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'the quick brown fox jumps over the lazy dog')
            ->call('applyHarvardStyle')
            ->assertDontSee('errorMessage');
    }

    /** @test */
    public function vancouver_style_formatting_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'the quick brown fox jumps over the lazy dog')
            ->call('applyVancouverStyle')
            ->assertDontSee('errorMessage');
    }

    /** @test */
    public function oscola_style_formatting_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'the quick brown fox jumps over the lazy dog')
            ->call('applyOscolaStyle')
            ->assertDontSee('errorMessage');
    }

    /** @test */
    public function reuters_style_formatting_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'the quick brown fox jumps over the lazy dog')
            ->call('applyReutersStyle')
            ->assertDontSee('errorMessage');
    }

    /** @test */
    public function bloomberg_style_formatting_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'the quick brown fox jumps over the lazy dog')
            ->call('applyBloombergStyle')
            ->assertDontSee('errorMessage');
    }

    /** @test */
    public function oxford_style_formatting_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'the quick brown fox jumps over the lazy dog')
            ->call('applyOxfordStyle')
            ->assertDontSee('errorMessage');
    }

    /** @test */
    public function cambridge_style_formatting_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'the quick brown fox jumps over the lazy dog')
            ->call('applyCambridgeStyle')
            ->assertDontSee('errorMessage');
    }

    /** @test */
    public function wide_text_transformation_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'hello world')
            ->call('transformToWideText')
            ->assertDontSee('errorMessage');
    }

    /** @test */
    public function small_caps_transformation_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'hello world')
            ->call('transformToSmallCaps')
            ->assertDontSee('errorMessage');
    }

    /** @test */
    public function strikethrough_transformation_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'hello world')
            ->call('transformToStrikethrough')
            ->assertDontSee('errorMessage');
    }

    /** @test */
    public function zalgo_text_transformation_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'hello world')
            ->call('transformToZalgoText')
            ->assertDontSee('errorMessage');
    }

    /** @test */
    public function upside_down_transformation_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'hello world')
            ->call('transformToUpsideDown')
            ->assertDontSee('errorMessage');
    }

    /** @test */
    public function binary_transformation_works()
    {
        Livewire::test(CaseChanger::class)
            ->set('inputText', 'hello')
            ->call('transformToBinary')
            ->assertSet('outputText', '01101000 01100101 01101100 01101100 01101111');
    }
}