<?php

namespace Bizprofi\Monitoring\Tests\Actions;

use PHPUnit\Framework\TestCase;
use Bizprofi\Monitoring\Actions\Find;
use \Bizprofi\Monitoring\Exceptions\FatalActionException;
use Bizprofi\Monitoring\Actions\ActionManager;

class FindJsonEncodeTest extends TestCase
{
    public function testJsonEncode()
    {
        $code = 'string';
        $identifier = 'monitoring';
        $context = 'Universal monitoring system';

        $action = new Find();
        $action->setCode($code);
        $action->setIdentifier($identifier);
        $action->setContext($context);

        $json = '{"type":"find","negated":false,"action":{"level":"F","chainable":true,"code":"string","identifier":"monitoring","context":"Universal monitoring system","childActions":false}}';
        
        $this->assertEquals(json_encode($action), $json);
        
        $action->setLevel('W');
        $json = '{"type":"find","negated":false,"action":{"level":"W","chainable":true,"code":"string","identifier":"monitoring","context":"Universal monitoring system","childActions":false}}';
        $this->assertEquals(json_encode($action), $json);
    }

    public function testJsonDecode()
    {
        $json = '{"type":"find","action":{"level":"W","chainable":true,"code":"string","identifier":"monitoring","context":"Universal monitoring system","childActions":false}}';

        $action = ActionManager::wakeUp($json);

        $this->assertTrue($action instanceof Find);
        $this->assertEquals($action->getCode(), 'string');
        $this->assertEquals($action->getIdentifier(), 'monitoring');
        $this->assertEquals($action->getContext(), 'Universal monitoring system');
        $this->assertEquals($action->getLevel(), 'W');
    }
}
