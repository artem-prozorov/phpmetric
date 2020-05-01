<?php

namespace PhpMetric\Tests\Traits\Actions;

use PHPUnit\Framework\TestCase;
use PhpMetric\Actions\AbstractAction;
use PhpMetric\Traits\Actions\Chainable;

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
