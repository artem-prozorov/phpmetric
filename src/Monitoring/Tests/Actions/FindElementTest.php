<?php

namespace Bizprofi\Monitoring\Tests\Actions;

use PHPUnit\Framework\TestCase;
use Bizprofi\Monitoring\Actions\Find;
use \Bizprofi\Monitoring\Exceptions\FatalActionException;

class FindElementTest extends TestCase
{
    protected $html;

    protected function setUp(): void
    {
        $this->html = <<<'HTML'
            <!DOCTYPE html>
            <html>
                <body>
                    <h1>This is page title</h1>
                    <p class="message">Hello <span>World!</span></p>
                    <p>Hello Crawler!</p>
                    <p class="links">
                        <a href="/link1">Link 1</a>
                        <a href="/link2">Link 2</a>
                        <a href="/link3">Link 3</a>
                    </p>
                </body>
            </html>
HTML;
    }

    public function testElementFindTitle()
    {
        $action = new Find('element', 'h1', $this->html);
        $action->execute();

        $this->assertEquals('<h1>This is page title</h1>', $action->getResult()->getData());
    }

    public function testElementFindElementByClassName()
    {
        $action = new Find('element', '.message', $this->html);
        $action->execute();

        $this->assertEquals(
            '<p class="message">Hello <span>World!</span></p>', 
            $action->getResult()->getData()
        );
    }

    public function testFindNonExistentElement()
    {
        $this->expectexception(FatalActionException::class);
        $action = new Find('element', '.non-existent-css-selector', $this->html);
        $action->execute();
    }

    public function testFindChildren()
    {
        $subaction = new Find('element', 'a:first-child');
        $subaction->addChildAction(new Find('string', 'Link 1'));
        $action = new Find('element', '.links', $this->html);
        $action->addChildAction($subaction);
        $action->execute();

        $this->assertEquals($subaction->getResult()->getData(), '<a href="/link1">Link 1</a>');

        $this->assertTrue($action->getResult()->isSuccess());
        $this->assertTrue($subaction->getResult()->isSuccess());
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
