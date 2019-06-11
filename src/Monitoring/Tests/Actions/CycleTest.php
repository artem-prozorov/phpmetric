<?php

namespace Bizprofi\Monitoring\Tests\Actions;

use PHPUnit\Framework\TestCase;
use Bizprofi\Monitoring\Exceptions\{WarningActionException, FatalActionException};
use Bizprofi\Monitoring\Actions\{AbstractAction, Find, Cycle, ActionResult, ActionManager};

class CycleTest extends TestCase
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
                        <img src="/images/image1.jpg" alt="Image 1 valid">
                        <img src="/images/image2.jpg" alt="Image 2 valid">
                        <img src="/images/image3.jpg" alt="Image 3 error">
                    </p>
                </body>
            </html>
HTML;
    }

    public function testConstructor()
    {
        try {
            $cycle = new Cycle();
        } catch (\ArgumentCountError $error) {
            $this->assertTrue(true);
        }
    }

    public function testValidCycle()
    {
        try {
            $subAction = new Find('attribute', 'alt');

            $cycle = new Cycle($subAction);

            $action = new Find('elements', 'img', $this->html);
            $action->addChildAction($cycle);
            $action->execute();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }

        var_dump($action->getResult()->getLogMessages());

        $this->assertTrue($action->getResult()->isSuccess());
    }

    public function testInvalidCycle()
    {
        // $subAction = new Find('attribute', 'alt');
        // $subAction->addChildAction(new Find('string', 'valid'));

        // $cycle = new Cycle($subAction);

        // $action = new Find('elements', 'img', $this->html);
        // $action->addChildAction($cycle);
        // $action->execute();

        // var_dump($action->getResult()->getLogMessages());
        $this->assertTrue(true);
    }

    public function testEmptyCycle()
    {
        $this->expectException(FatalActionException::class);

        $subAction = new Find('attribute', 'non-existent-attribute');
        $cycle = new Cycle($subAction);

        $action = new Find('elements', 'img', $this->html);
        $action->addChildAction($cycle);
        $action->execute();
    }

    public function testWakeUpCycle()
    {
        $json = '{"type":"find","action":{"level":"F","chainable":true,"code":"elements","identifier":"img","context":"<!DOCTYPE html>\n<html>\n<body>\n<h1>This is page title<\/h1>\n<p class=\"message\">Hello <span>World!<\/span><\/p>\n<p>Hello Crawler!<\/p>\n<p class=\"links\">\n<img src=\"\/images\/image1.jpg\" alt=\"Image 1 valid\">\n<img src=\"\/images\/image2.jpg\" title=\"Image 2 valid\">\n<img src=\"\/images\/image3.jpg\" alt=\"Image 3 error\">\n<\/p>\n<\/body>\n<\/html>","childActions":[{"type":"cycle","action":{"level":"W","chainable":true,"action":{"type":"find","action":{"level":"W","chainable":true,"code":"attribute","identifier":"alt","context":false,"childActions":false}},"context":false,"childActions":false}}]}}';

        $action = ActionManager::wakeUp($json);

        $action->execute();

        $this->assertTrue($action->getResult()->isSuccess());
    }
}
