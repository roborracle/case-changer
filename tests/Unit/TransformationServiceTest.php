<?php

// WHY THIS FILE EXISTS: To provide a fast, reliable, and isolated validation of the TransformationService's logic.
// WHAT THIS FILE MUST NEVER DO: It must never depend on external classes, the framework's state, or anything outside of the TransformationService itself.
// SUCCESS DEFINITION: This file is successful if it can prove, with 100% certainty, that every transformation function behaves as expected.

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\TransformationService;

class TransformationServiceTest extends TestCase
{
    protected $transformationService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->transformationService = new TransformationService();
    }

    public function test_it_transforms_to_uppercase_correctly()
    {
        $inputText = 'Hello World';
        $expectedText = 'HELLO WORLD';
        $outputText = $this->transformationService->transform($inputText, 'upper-case');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_lowercase_correctly()
    {
        $inputText = 'Hello World';
        $expectedText = 'hello world';
        $outputText = $this->transformationService->transform($inputText, 'lower-case');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_title_case_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'Hello World';
        $outputText = $this->transformationService->transform($inputText, 'title-case');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_sentence_case_correctly()
    {
        $inputText = 'hello world. this is a test.';
        $expectedText = 'Hello world. this is a test.';
        $outputText = $this->transformationService->transform($inputText, 'sentence-case');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_capitalize_words_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'Hello World';
        $outputText = $this->transformationService->transform($inputText, 'capitalize-words');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_alternating_case_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'hElLo wOrLd';
        $outputText = $this->transformationService->transform($inputText, 'alternating-case');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_inverse_case_correctly()
    {
        $inputText = 'Hello World';
        $expectedText = 'hELLO wORLD';
        $outputText = $this->transformationService->transform($inputText, 'inverse-case');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_camel_case_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'helloWorld';
        $outputText = $this->transformationService->transform($inputText, 'camel-case');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_pascal_case_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'HelloWorld';
        $outputText = $this->transformationService->transform($inputText, 'pascal-case');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_snake_case_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'hello_world';
        $outputText = $this->transformationService->transform($inputText, 'snake-case');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_constant_case_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'HELLO_WORLD';
        $outputText = $this->transformationService->transform($inputText, 'constant-case');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_kebab_case_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'hello-world';
        $outputText = $this->transformationService->transform($inputText, 'kebab-case');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_dot_case_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'hello.world';
        $outputText = $this->transformationService->transform($inputText, 'dot-case');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_path_case_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'hello/world';
        $outputText = $this->transformationService->transform($inputText, 'path-case');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_ap_style_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'AP Style: Hello World';
        $outputText = $this->transformationService->transform($inputText, 'ap-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_nyt_style_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'NY Times Style: Hello World';
        $outputText = $this->transformationService->transform($inputText, 'nyt-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_chicago_style_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'Chicago Style: Hello World';
        $outputText = $this->transformationService->transform($inputText, 'chicago-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_guardian_style_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'Guardian Style: Hello World';
        $outputText = $this->transformationService->transform($inputText, 'guardian-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_bbc_style_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'BBC Style: Hello World';
        $outputText = $this->transformationService->transform($inputText, 'bbc-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_reuters_style_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'Reuters Style: Hello World';
        $outputText = $this->transformationService->transform($inputText, 'reuters-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_economist_style_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'Economist Style: Hello World';
        $outputText = $this->transformationService->transform($inputText, 'economist-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_wsj_style_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'WSJ Style: Hello World';
        $outputText = $this->transformationService->transform($inputText, 'wsj-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_apa_style_correctly()
    {
        $inputText = 'hello world. this is a test.';
        $expectedText = 'APA Style: Hello world. this is a test.';
        $outputText = $this->transformationService->transform($inputText, 'apa-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_mla_style_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'MLA Style: Hello World';
        $outputText = $this->transformationService->transform($inputText, 'mla-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_chicago_author_date_correctly()
    {
        $inputText = 'hello world. this is a test.';
        $expectedText = 'Chicago Author-Date: Hello world. this is a test.';
        $outputText = $this->transformationService->transform($inputText, 'chicago-author-date');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_chicago_notes_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'Chicago Notes: Hello World';
        $outputText = $this->transformationService->transform($inputText, 'chicago-notes');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_harvard_style_correctly()
    {
        $inputText = 'hello world. this is a test.';
        $expectedText = 'Harvard Style: Hello world. this is a test.';
        $outputText = $this->transformationService->transform($inputText, 'harvard-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_vancouver_style_correctly()
    {
        $inputText = 'hello world. this is a test.';
        $expectedText = 'Vancouver Style: Hello world. this is a test.';
        $outputText = $this->transformationService->transform($inputText, 'vancouver-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_ieee_style_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'IEEE Style: Hello World';
        $outputText = $this->transformationService->transform($inputText, 'ieee-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_ama_style_correctly()
    {
        $inputText = 'hello world. this is a test.';
        $expectedText = 'AMA Style: Hello world. this is a test.';
        $outputText = $this->transformationService->transform($inputText, 'ama-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_bluebook_style_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'Bluebook Style: Hello World';
        $outputText = $this->transformationService->transform($inputText, 'bluebook-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_reverse_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'dlrow olleh';
        $outputText = $this->transformationService->transform($inputText, 'reverse');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_aesthetic_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'H E L L O   W O R L D';
        $outputText = $this->transformationService->transform($inputText, 'aesthetic');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_sarcasm_case_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'hElLo wOrLd';
        $outputText = $this->transformationService->transform($inputText, 'sarcasm');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_smallcaps_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'Small Caps: HELLO WORLD';
        $outputText = $this->transformationService->transform($inputText, 'smallcaps');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_bubble_text_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'Bubble Text: hello world';
        $outputText = $this->transformationService->transform($inputText, 'bubble');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_square_text_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'Square Text: hello world';
        $outputText = $this->transformationService->transform($inputText, 'square');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_script_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'Script: hello world';
        $outputText = $this->transformationService->transform($inputText, 'script');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_double_struck_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'Double Struck: hello world';
        $outputText = $this->transformationService->transform($inputText, 'double-struck');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_bold_correctly()
    {
        $inputText = 'hello world';
        $expectedText = '**hello world**';
        $outputText = $this->transformationService->transform($inputText, 'bold');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_italic_correctly()
    {
        $inputText = 'hello world';
        $expectedText = '*hello world*';
        $outputText = $this->transformationService->transform($inputText, 'italic');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_emoji_case_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'hello world ✨';
        $outputText = $this->transformationService->transform($inputText, 'emoji-case');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_email_style_correctly()
    {
        $inputText = 'hello world. this is a test.';
        $expectedText = 'Email Style: Hello world. this is a test.';
        $outputText = $this->transformationService->transform($inputText, 'email-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_legal_style_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'Legal Style: HELLO WORLD';
        $outputText = $this->transformationService->transform($inputText, 'legal-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_marketing_headline_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'Marketing Headline: Hello World';
        $outputText = $this->transformationService->transform($inputText, 'marketing-headline');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_press_release_correctly()
    {
        $inputText = 'hello world. this is a test.';
        $expectedText = 'Press Release: Hello world. this is a test.';
        $outputText = $this->transformationService->transform($inputText, 'press-release');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_memo_style_correctly()
    {
        $inputText = 'hello world. this is a test.';
        $expectedText = 'Memo Style: Hello world. this is a test.';
        $outputText = $this->transformationService->transform($inputText, 'memo-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_report_style_correctly()
    {
        $inputText = 'hello world. this is a test.';
        $expectedText = 'Report Style: Hello world. this is a test.';
        $outputText = $this->transformationService->transform($inputText, 'report-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_proposal_style_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'Proposal Style: Hello World';
        $outputText = $this->transformationService->transform($inputText, 'proposal-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_invoice_style_correctly()
    {
        $inputText = 'hello world. this is a test.';
        $expectedText = 'Invoice Style: Hello world. this is a test.';
        $outputText = $this->transformationService->transform($inputText, 'invoice-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_twitter_style_correctly()
    {
        $inputText = 'hello world. this is a test.';
        $expectedText = 'Twitter/X Style: Hello world. this is a test.';
        $outputText = $this->transformationService->transform($inputText, 'twitter-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_instagram_style_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'Instagram Style: Hello World';
        $outputText = $this->transformationService->transform($inputText, 'instagram-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_linkedin_style_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'LinkedIn Style: Hello World';
        $outputText = $this->transformationService->transform($inputText, 'linkedin-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_facebook_style_correctly()
    {
        $inputText = 'hello world. this is a test.';
        $expectedText = 'Facebook Style: Hello world. this is a test.';
        $outputText = $this->transformationService->transform($inputText, 'facebook-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_youtube_title_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'YouTube Title: Hello World';
        $outputText = $this->transformationService->transform($inputText, 'youtube-title');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_tiktok_style_correctly()
    {
        $inputText = 'hello world. this is a test.';
        $expectedText = 'TikTok Style: Hello world. this is a test.';
        $outputText = $this->transformationService->transform($inputText, 'tiktok-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_hashtag_style_correctly()
    {
        $inputText = 'hello world';
        $expectedText = '#HelloWorld';
        $outputText = $this->transformationService->transform($inputText, 'hashtag-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_mention_style_correctly()
    {
        $inputText = 'hello world';
        $expectedText = '@helloWorld';
        $outputText = $this->transformationService->transform($inputText, 'mention-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_api_docs_correctly()
    {
        $inputText = 'hello world. this is a test.';
        $expectedText = 'API Documentation: Hello world. this is a test.';
        $outputText = $this->transformationService->transform($inputText, 'api-docs');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_readme_style_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'README Style: Hello World';
        $outputText = $this->transformationService->transform($inputText, 'readme-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_changelog_style_correctly()
    {
        $inputText = 'hello world. this is a test.';
        $expectedText = 'Changelog Style: Hello world. this is a test.';
        $outputText = $this->transformationService->transform($inputText, 'changelog-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_user_manual_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'User Manual: Hello World';
        $outputText = $this->transformationService->transform($inputText, 'user-manual');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_technical_spec_correctly()
    {
        $inputText = 'hello world. this is a test.';
        $expectedText = 'Technical Spec: Hello world. this is a test.';
        $outputText = $this->transformationService->transform($inputText, 'technical-spec');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_code_comments_correctly()
    {
        $inputText = 'hello world. this is a test.';
        $expectedText = '// Hello world. this is a test.';
        $outputText = $this->transformationService->transform($inputText, 'code-comments');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_wiki_style_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'Wiki Style: Hello World';
        $outputText = $this->transformationService->transform($inputText, 'wiki-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_markdown_style_correctly()
    {
        $inputText = 'hello world. this is a test.';
        $expectedText = 'Markdown Style: Hello world. this is a test.';
        $outputText = $this->transformationService->transform($inputText, 'markdown-style');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_british_english_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'British English: hello world';
        $outputText = $this->transformationService->transform($inputText, 'british-english');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_american_english_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'American English: hello world';
        $outputText = $this->transformationService->transform($inputText, 'american-english');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_canadian_english_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'Canadian English: hello world';
        $outputText = $this->transformationService->transform($inputText, 'canadian-english');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_australian_english_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'Australian English: hello world';
        $outputText = $this->transformationService->transform($inputText, 'australian-english');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_eu_format_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'EU Format: hello world';
        $outputText = $this->transformationService->transform($inputText, 'eu-format');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_iso_format_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'ISO Format: hello world';
        $outputText = $this->transformationService->transform($inputText, 'iso-format');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_unicode_normalize_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'Unicode Normalize: hello world';
        $outputText = $this->transformationService->transform($inputText, 'unicode-normalize');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_ascii_convert_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'ASCII Convert: hello world';
        $outputText = $this->transformationService->transform($inputText, 'ascii-convert');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_remove_spaces_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'helloworld';
        $outputText = $this->transformationService->transform($inputText, 'remove-spaces');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_remove_extra_spaces_correctly()
    {
        $inputText = '  hello   world  ';
        $expectedText = 'hello world';
        $outputText = $this->transformationService->transform($inputText, 'remove-extra-spaces');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_add_dashes_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'hello-world';
        $outputText = $this->transformationService->transform($inputText, 'add-dashes');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_add_underscores_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'hello_world';
        $outputText = $this->transformationService->transform($inputText, 'add-underscores');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_add_periods_correctly()
    {
        $inputText = 'hello world';
        $expectedText = 'hello.world';
        $outputText = $this->transformationService->transform($inputText, 'add-periods');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_remove_punctuation_correctly()
    {
        $inputText = 'Hello, World! How are you?';
        $expectedText = 'Hello World How are you';
        $outputText = $this->transformationService->transform($inputText, 'remove-punctuation');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_extract_letters_correctly()
    {
        $inputText = 'Hello World 123!';
        $expectedText = 'HelloWorld';
        $outputText = $this->transformationService->transform($inputText, 'extract-letters');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_extract_numbers_correctly()
    {
        $inputText = 'Hello World 123!';
        $expectedText = '123';
        $outputText = $this->transformationService->transform($inputText, 'extract-numbers');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_remove_duplicates_correctly()
    {
        $inputText = 'hello world hello again';
        $expectedText = 'hello world again';
        $outputText = $this->transformationService->transform($inputText, 'remove-duplicates');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_sort_words_correctly()
    {
        $inputText = 'zebra apple banana';
        $expectedText = 'apple banana zebra';
        $outputText = $this->transformationService->transform($inputText, 'sort-words');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_transforms_to_shuffle_words_correctly()
    {
        $inputText = 'one two three';
        $outputText = $this->transformationService->transform($inputText, 'shuffle-words');
        $this->assertNotEquals('one two three', $outputText); // Unlikely to be the same
        $this->assertCount(3, explode(' ', $outputText));
    }

    public function test_it_transforms_to_word_frequency_correctly()
    {
        $inputText = 'apple banana apple orange banana apple';
        $expectedText = 'apple: 3, banana: 2, orange: 1';
        $outputText = $this->transformationService->transform($inputText, 'word-frequency');
        $this->assertEquals($expectedText, $outputText);
    }

    public function test_it_returns_original_text_for_unknown_transformation()
    {
        $inputText = 'Hello World';
        $outputText = $this->transformationService->transform($inputText, 'non-existent-transformation');
        $this->assertEquals($inputText, $outputText);
    }
}
