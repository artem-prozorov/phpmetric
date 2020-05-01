<?php

namespace PhpMetric\Tests\Actions;

use PHPUnit\Framework\TestCase;
use PhpMetric\Actions\Find;
use \PhpMetric\Exceptions\FatalActionException;

class FindAttributeTest extends TestCase
{
    protected $html;

    protected function setUp(): void
    {
        $this->html = <<<'HTML'
            <!DOCTYPE html>
            <html>
                <body>
                    <h1 class="page-title" style="font-size: 20px">This is page title</h1>
                    <p class="message">Hello <span>World!</span></p>
                    <p>Hello Crawler!</p>
                    <p class="links">
                        <a href="/link1">Link 1</a>
                        <a href="/link2">Link 2</a>
                        <a href="/link3">Link 3</a>
                    </p>
                    <img src="/images/products/znch_1530359307.jpg" alt="Test alt">
                </body>
            </html>
HTML;
    }

    public function testFindChildren()
    {
        $subaction = new Find('attribute', 'style');

        $action = new Find('element', 'h1', $this->html);
        $action->addChildAction($subaction);
        $action->execute();

        $this->assertTrue($action->getResult()->isSuccess());
        $this->assertTrue($subaction->getResult()->isSuccess());

        $this->assertEquals($subaction->getResult()->getData(), 'font-size: 20px');
    }

    /**
     * ./vendor/bin/phpunit --filter testFindImg FindAttributeTest src/Monitoring/Tests/Actions/FindAttributeTest.php
     */
    public function testFindImg()
    {
        $subaction = new Find('attribute', 'alt');

        $action = new Find('element', 'img', $this->html);
        $action->addChildAction($subaction);
        $action->execute();

        $this->assertTrue($action->getResult()->isSuccess());
        $this->assertTrue($subaction->getResult()->isSuccess());

        $this->assertEquals($subaction->getResult()->getData(), 'Test alt');
    }

    public function testFindImgSingleTag()
    {
        $html = '<img src="https://mc.yandex.ru/watch/45345405" style="position:absolute; left:-9999px;" alt="test">';

        $action = new Find('attribute', 'alt', $html);
        $action->execute();

        $this->assertTrue($action->getResult()->isSuccess());

        $this->assertEquals($action->getResult()->getData(), 'test');
    }

    public function testFailFindChildren()
    {
        $subSubAction = new Find('string', 'Non-existent string');
        $subSubAction->warning();

        $subaction = new Find('element', 'a:first-child');
        $subaction->addChildAction($subSubAction);

        $action = new Find('element', '.links', $this->html);
        $action->addChildAction($subaction);
        $action->execute();

        $this->assertTrue($action->getResult()->isSuccess());
        $this->assertTrue($subaction->getResult()->isSuccess());
        $this->assertFalse($subSubAction->getResult()->isSuccess());
    }
}
