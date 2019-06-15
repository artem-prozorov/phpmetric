<?php

namespace Bizprofi\Monitoring\Tests\Actions;

use PHPUnit\Framework\TestCase;
use Bizprofi\Monitoring\Actions\Http\Request;
use \Bizprofi\Monitoring\Exceptions\FatalActionException;
use Bizprofi\Monitoring\Actions\Find;

class RequestAddressTest extends TestCase
{
    public function testRequestUrl()
    {
        $subAction = new Find('string', '200');

        $action = new Request('status', 'http://fermerator.ru');
        $action->addChildAction($subAction);
        $action->execute();

        // var_dump($action->getResult()->getData());

        // var_dump($action->getResult()->getLogMessages());

        $this->assertTrue($action->getResult()->isSuccess());

        // $this->assertEquals($subaction->getResult()->getData(), 'font-size: 20px');
    }
}
