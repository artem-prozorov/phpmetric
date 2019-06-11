<?php

namespace Bizprofi\Monitoring\Tests\Actions;

use PHPUnit\Framework\TestCase;
use Bizprofi\Monitoring\Actions\AbstractAction;
use Bizprofi\Monitoring\Actions\ActionResult;
use Bizprofi\Monitoring\Exceptions\FatalActionException;
use Bizprofi\Monitoring\Exceptions\WarningActionException;

class AbstractActionTest extends TestCase
{
    public function testTrait()
    {
        $class = new class extends AbstractAction {
            public function execute()
            {
                
            }
        };

        $result = $class->getResult();
        $this->assertTrue($result instanceof ActionResult);

        $this->assertEquals($class->getLevel(), AbstractAction::FATAL);
        
        $class->setLevel(AbstractAction::WARNING);
        $this->assertEquals($class->getLevel(), AbstractAction::WARNING);

        $this->expectException(\InvalidArgumentException::class);
        $class->setLevel('Non-existent level');
    }

    public function testFatalLevel()
    {
        $class = new class extends AbstractAction {
            public function execute()
            {
                $this->fail(new \Exception('Test error occured'));
            }
        };

        $this->expectException(FatalActionException::class);
        $result = $class->execute();
    }

    public function testWarningLevel()
    {
        $class = new class extends AbstractAction {
            public function execute()
            {
                $this->fail(new \Exception('Test error occured'));
            }
        };

        $class->setLevel(AbstractAction::WARNING);

        $this->expectException(WarningActionException::class);
        $result = $class->execute();
    }

    public function testAddWarning()
    {
        $class = new class extends AbstractAction {
            public function execute()
            {
                
            }
        };

        $class->addWarning(new WarningActionException('Test exception'));

        $this->assertTrue(true);
    }
}
