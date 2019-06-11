<?php

namespace Bizprofi\Monitoring\Tests\Traits\Http;

use PHPUnit\Framework\TestCase;
use Bizprofi\Monitoring\Traits\Http\CanParseHtml as CanParseHtmlTrait;

class CanParseHtmlTest extends TestCase
{
    public function testTrait()
    {
        $html = <<<'HTML'
            <!DOCTYPE html>
            <html>
                <body>
                    <p class="message">Hello World!</p>
                    <p>Hello Crawler!</p>
                </body>
            </html>
HTML;

        $class = new class {
            use CanParseHtmlTrait;
        };

        $crawler = $class->initCrawler()->setHtml($html)->parse();
        $this->assertEquals($crawler->filter('body > p')->first()->text(), 'Hello World!');
    }

    public function testInvalidParameters()
    {
        $class = new class {
            use CanParseHtmlTrait;
            public function execute()
            {
                
            }
        };

        $this->expectException(\BadMethodCallException::class);
        $class->parse();
    }

    public function testSettersAndGetters()
    {
        $class = new class {
            use CanParseHtmlTrait;
            public function execute()
            {
                
            }
        };

        $class->setHtml('string');
        $this->assertEquals($class->getHtml(), 'string');
    }
}
