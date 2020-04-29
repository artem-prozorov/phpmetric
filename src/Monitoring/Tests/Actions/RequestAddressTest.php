<?php

namespace Bizprofi\Monitoring\Tests\Actions;

use PHPUnit\Framework\TestCase;
use Bizprofi\Monitoring\Actions\Http\Request;
use \Bizprofi\Monitoring\Exceptions\FatalActionException;
use Bizprofi\Monitoring\Actions\Find;
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
