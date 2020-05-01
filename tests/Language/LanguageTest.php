<?php

namespace PhpMetric\Tests\Actions;

use PHPUnit\Framework\TestCase;
use PhpMetric\Language\Language;

class LanguageTest extends TestCase
{
    public function testLocaleLoading()
    {
        Language::setLocale('Test');

        $this->assertEquals(Language::getLocale(), 'Test');

        $this->expectException(\InvalidArgumentException::class);
        Language::setLocale('Non-existent-locale');
    }

    public function testLoadingInvalidLocaleFile()
    {
        Language::setLocale('Test');

        $this->expectException(\InvalidArgumentException::class);
        Language::loadFile('Non-existent-locale-file');
    }

    public function testLoadingLocaleData()
    {
        Language::setLocale('Test');
        Language::loadFile('test');

        $testPhrase = Language::get('TEST_PHRASE');
        $testPhraseWithParameter = Language::get('TEST_PHRASE_WITH_ONE_PARAMETER', ['REPLACE' => '"replaced data"']);
        $testPhraseWithParameters = Language::get(
            'TEST_PHRASE_WITH_MULTIPLE_PARAMETERS', 
            ['REPLACE_ONE' => '"replaced data one"', 'REPLACE_TWO' => '"second replaced data"']
        );

        $this->assertEquals($testPhrase, 'This is a test phrase');
        $this->assertEquals(
            $testPhraseWithParameter, 
            'This is a test phrase with a single parameter that is a "replaced data"'
        );
        $this->assertEquals(
            $testPhraseWithParameters, 
            'This is a test phrase with multipla parameters that are "replaced data one" and "second replaced data"'
        );
    }
}
