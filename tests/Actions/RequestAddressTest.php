<?php

namespace PhpMetric\Tests\Actions;

use PHPUnit\Framework\TestCase;
use PhpMetric\Actions\Http\Request;
use \PhpMetric\Exceptions\FatalActionException;
use PhpMetric\Actions\Find;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class RequestAddressTest extends TestCase
{
    public function testRequestUrl()
    {
        $response = $this->createMock(Response::class);
        $response->method('getStatusCode')->willReturn(200);

        $client = $this->createMock(Client::class);
        $client->method('request')->willReturn($response);

        $subAction = new Find('string', '200');

        $action = new Request('status', 'http://site.local');

        $action->getEngine()->initClient($client);

        $action->addChildAction($subAction);
        $action->execute();

        $this->assertTrue($action->getResult()->isSuccess());
    }
}
