<?php

namespace PhpMetric\Tests\Actions;

use PHPUnit\Framework\TestCase;
use PhpMetric\Actions\Find;
use \PhpMetric\Exceptions\FatalActionException;

class FindElementsTest extends TestCase
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
                        <a href="/link1" class="testClass">Link 1</a>
                        <a href="/link2">Link 2</a>
                        <a href="/link3" class="testClass">Link 3</a>
                    </p>
                </body>
            </html>
HTML;
    }

    public function provider(): array
    {
        return [
            [
                'a',
                [
                    'count' => 3,
                    'isSuccess' => true,
                ],
            ],
            [
                'p',
                [
                    'count' => 3,
                    'isSuccess' => true,
                ],
            ],
            [
                '.testClass',
                [
                    'count' => 2,
                    'isSuccess' => true,
                ],
            ],
        ];
    }

    /**
     * testElementFindTitle
     *
     * @dataProvider provider
     * @param string $needle
     * @param array $data
     * @return void
     */
    public function testElementFindTitle(string $needle, array $data)
    {
        $action = new Find('elements', $needle, $this->html);
        $action->execute();

        $this->assertEquals(count($action->getResult()->getData()), $data['count']);
        $this->assertEquals($action->getResult()->isSuccess(), $data['isSuccess']);
    }
}
