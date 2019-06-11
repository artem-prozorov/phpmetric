<?php

namespace Bizprofi\Monitoring\Tests\Traits\Actions;

use PHPUnit\Framework\TestCase;
use Bizprofi\Monitoring\Actions\AbstractAction;
use Bizprofi\Monitoring\Traits\Actions\Chainable;

class ChainableTest extends TestCase
{
    public function testTrait()
    {
        $class = new class extends AbstractAction {
            use Chainable;
            public function execute()
            {
                
            }
        };

        $this->assertTrue($class->isChainable());
    }
}
