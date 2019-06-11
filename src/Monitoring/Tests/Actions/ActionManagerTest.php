<?php

namespace Bizprofi\Monitoring\Tests\Actions;

use PHPUnit\Framework\TestCase;
use Bizprofi\Monitoring\Actions\ActionManager;
use Bizprofi\Monitoring\Exceptions\FatalActionException;

class ActionManagerTest extends TestCase
{
    /**
     * testWakeUp
     *
     * @param mixed $json
     * @dataProvider jsonProvider
     */
    public function testWakeUp($json, $code, $identifier, $context, $level)
    {
        $action = ActionManager::wakeUp($json);

        $this->assertEquals($action->getCode(), $code);
        $this->assertEquals($action->getIdentifier(), $identifier);
        $this->assertEquals($action->getContext(), $context);
        $this->assertEquals($action->getLevel(), $level);
    }

    public function jsonProvider()
    {
        return [
            [
                '{
                    "type":"find",
                    "action":{
                        "level":"F",
                        "chainable":true,
                        "code":"string",
                        "identifier":"monitoring",
                        "context":"Universal monitoring system"
                    }
                }',
                'string',
                'monitoring',
                'Universal monitoring system',
                'F'
            ],
            [
                '{
                    "type":"find",
                    "action":{
                        "level":"F",
                        "chainable":true,
                        "code":"string",
                        "identifier":"non-existent",
                        "context":"Universal monitoring system",
                        "childActions":[
                            {
                                "type":"find",
                                "action":{
                                    "level":"F",
                                    "chainable":true,
                                    "code":"string",
                                    "identifier":"mon",
                                    "context":false,
                                    "childActions":false
                                }
                            }
                        ]
                    }
                }',
                'string',
                'non-existent',
                'Universal monitoring system',
                'F'
            ],
            [
                '{
                    "type":"find",
                    "action":{
                        "level":"W",
                        "chainable":true,
                        "code":"string",
                        "identifier":"monitoring",
                        "context":"Universal monitoring system"
                    }
                }',
                'string',
                'monitoring',
                'Universal monitoring system',
                'W'
            ],
        ];
    }
}
