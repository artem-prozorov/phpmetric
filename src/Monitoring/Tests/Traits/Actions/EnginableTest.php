<?php

namespace Bizprofi\Monitoring\Tests\Traits\Actions;

use PHPUnit\Framework\TestCase;
use Bizprofi\Monitoring\Actions\AbstractAction;
use Bizprofi\Monitoring\Traits\Actions\Enginable;
use Bizprofi\Monitoring\Interfaces\EngineInterface;

class EnginableTest extends TestCase
{
    public function testEmptyEngine()
    {
        $class = new class extends AbstractAction {
            use Enginable;

            public function execute()
            {
                
            }
        };

        try {
            $class->getEngine();
        } catch (\BadMethodCallException $e) {
            $this->assertTrue(true);
        }

        return $class;
    }

    /**
     * @depends testEmptyEngine
     */
    public function testSettersAndGetters($class)
    {
        $engine = new class implements EngineInterface {

            public function find($needle)
            {
                
            }

            public function setContext($context)
            {
                
            }
        };

        $class->setEngine($engine);
        $this->assertEquals($class->getEngine(), $engine);

        $class->setCode('test_code');
        $this->assertEquals($class->getCode(), 'test_code');

        $class->setIdentifier('test_id');
        $this->assertEquals($class->getIdentifier(), 'test_id');
    }
}
