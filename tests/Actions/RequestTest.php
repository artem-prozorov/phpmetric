<?php

namespace PhpMetric\Tests\Actions;

use PHPUnit\Framework\TestCase;
use PhpMetric\Actions\ActionManager;
use PhpMetric\Actions\Http\Request;
use PhpMetric\Exceptions\FatalActionException;

class RequestTest extends TestCase
{
    public function testExecute()
    {
        $contents = new class {
            protected $body = '';

            public function setContents($body)
            {
                $this->body = $body;
            }

            public function getContents()
            {
                return $this->body;
            }
        };

        $contents->setContents($this->getRequestBody());

        $httpResponse = $this->createMock(\GuzzleHttp\Psr7\Response::class);
        $httpResponse->method('getStatusCode')->willReturn(200);
        $httpResponse->method('getBody')->willReturn($contents);

        $httpClient = $this->createMock(\GuzzleHttp\Client::class);
        $httpClient->method('request')->willReturn($httpResponse);

        $request = new Request('url', 'https://google.com');
        $engine = $request->getEngine();
        $engine->initClient($httpClient);

        $request->execute();

        $this->assertTrue($request->getResult()->isSuccess());
    }

    // public function testExecute()
    // {
    //     $request = new Request('url', 'https://fermerator.ru');

    //     $this->contents->setContents($this->getRequestBody());
    //     $httpResponse = $this->createMock(\GuzzleHttp\Psr7\Response::class);
    //     $httpResponse->method('getStatusCode')->willReturn(200);
    //     $httpResponse->method('getBody')->willReturn($this->contents);
    //     $httpClient = $this->createMock(\GuzzleHttp\Client::class);
    //     $httpClient->method('request')->willReturn($httpResponse);

    //     $request->initClient($httpClient);
    //     $request->execute();

    //     $this->assertTrue($request->getResult()->isSuccess());
    // }

//     public function testGetHead()
//     {
//         $request = new Request('status', 'https://fermerator.ru');

//         // $this->contents->setContents($this->getRequestBody());
//         // $httpResponse = $this->createMock(\GuzzleHttp\Psr7\Response::class);
//         // $httpResponse->method('getStatusCode')->willReturn(200);
//         // $httpResponse->method('getBody')->willReturn($this->contents);
//         // $httpClient = $this->createMock(\GuzzleHttp\Client::class);
//         // $httpClient->method('request')->willReturn($httpResponse);

//         $request->execute();

//         // $this->assertTrue($request->getResult()->isSuccess());
//         var_dump($request->getResult());
//         $this->assertTrue(true);
//     }

//     /**
//      * testWakeUp
//      *
//      * @dataProvider jsonProvider
//      */
//     public function testWakeUp($json, $level, $code, $url, $params)
//     {
//         $action = ActionManager::wakeUp($json);

//         $this->assertEquals($action->getLevel(), $level);
//         $this->assertEquals($action->getCode(), $code);
//         $this->assertEquals($action->getUrl(), $url);
//         $this->assertEquals($action->getParams(), $params);

//         $action->execute();
//         $this->assertTrue($action->getResult()->isSuccess());
//     }

//     public function jsonProvider()
//     {
//         return [
//             [
//                 '{"type":"Request","action":{"level":"F","chainable":true,"code":"url","url":"https:\/\/fermerator.ru","params":[],"childActions":false}}',
//                 'F',
//                 'url',
//                 'https://fermerator.ru',
//                 []
//             ],
//             [
//                 '{"type":"Request","action":{"level":"W","chainable":true,"code":"url","url":"https:\/\/yandex.ru","params":[],"childActions":false}}',
//                 'W',
//                 'url',
//                 'https://yandex.ru',
//                 []
//             ],
//             [
//                 '{"type":"Request","action":{"level":"F","chainable":true,"code":"url","url":"https:\/\/google.com","params":{"method":"POST"},"childActions":false}}',
//                 'F',
//                 'url',
//                 'https://google.com',
//                 ['method' => 'POST']
//             ],
//         ];
//     }

    public function getRequestBody(): string
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

        return $html;
    }
}
