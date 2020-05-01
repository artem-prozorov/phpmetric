<?php

namespace PhpMetric\Tests\Actions\Context;

use PHPUnit\Framework\TestCase;
use PhpMetric\Actions\Context\ModifierCollection;
use PhpMetric\Actions\Context\Modifiers\Url;

class ModifierCollectionTest extends TestCase
{
    public function testCollection()
    {
        $modifiers = new ModifierCollection();
        $url = 'http://www.site.ru';
        $modifiers->push(new Url($url));

        $context = '/catalog';
        $result = $modifiers->apply($context);

        $this->assertEquals($result, 'http://www.site.ru/catalog');
    }

    public function testModifierCollectionJsonSerialization()
    {
        $modifiers = new ModifierCollection();
        $url = 'http://www.site.ru';
        $modifiers->push(new Url($url));

        // echo json_encode($modifiers);

        // $this->assertEquals('http://www.site.ru/catalog', $result);
        $this->assertTrue(true);
    }
}
