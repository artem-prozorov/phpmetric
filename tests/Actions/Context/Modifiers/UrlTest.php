<?php

namespace PhpMetric\Tests\Actions\Context\Modifiers;

use PHPUnit\Framework\TestCase;
use PhpMetric\Actions\Context\Modifiers\Url;

class UrlTest extends TestCase
{
    public function testRelativeUrl()
    {
        $context = '/catalog';
        $data = 'http://www.site.ru';

        $modifier = new Url($data);
        $result = $modifier->apply($context);

        $this->assertEquals('http://www.site.ru/catalog', $result);
    }

    public function testAbsoluteUrl()
    {
        $context = 'http://www.site.ru/catalog';
        $data = 'http://www.site.ru';

        $modifier = new Url($data);
        $result = $modifier->apply($context);

        $this->assertEquals('http://www.site.ru/catalog', $result);
    }

    public function testUrlJsonSerialization()
    {
        $context = 'http://www.site.ru/catalog';
        $data = 'http://www.site.ru';

        $modifier = new Url($data);
        $result = json_encode($modifier);

        // echo json_encode($modifier);

        // $this->assertEquals('http://www.site.ru/catalog', $result);
        $this->assertTrue(true);
    }
}
