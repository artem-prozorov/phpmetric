<?php

namespace PhpMetric\Tests\Traits\Http;

use PHPUnit\Framework\TestCase;
use PhpMetric\Traits\Http\CanMakeRequests as CanMakeRequestsTrait;

class CanMakeRequestsTest extends TestCase
{
    protected $class;

    protected function setUp(): void
    {
        $this->class = new class {
            use CanMakeRequestsTrait;
            public function execute()
            {
                
            }
        };
    }

    public function testTrait()
    {
        $httpResponse = $this->createMock(\GuzzleHttp\Psr7\Response::class);
        $httpResponse->method('getStatusCode')->willReturn(200);

        $httpClient = $this->createMock(\GuzzleHttp\Client::class);
        $httpClient->method('request')->willReturn($httpResponse);

        $this->class->initClient($httpClient);
        $this->assertEquals($this->class->getMethod(), 'GET');
    }

    public function testCodes()
    {
        $httpResponse = $this->createMock(\GuzzleHttp\Psr7\Response::class);
        $httpResponse->method('getStatusCode')->willReturn(404);

        $httpClient = $this->createMock(\GuzzleHttp\Client::class);
        $httpClient->method('request')->willReturn($httpResponse);

        $this->class->initClient($httpClient);

        $this->expectException(\UnexpectedValueException::class);
        $response = $this->class->makeRequest('https://www.google.ru/')->getResponse();
    }
}
