<?php

namespace PhpMetric\Tests\Collections;

use PHPUnit\Framework\TestCase;
use PhpMetric\Collections\ActionCollection;
use PhpMetric\Actions\AbstractAction;

class ActionCollectionTest extends TestCase
{
    protected $collection;

    protected function setUp(): void
    {
        $this->collection = new ActionCollection();
    }

    public function testPush()
    {
        $action = new class extends AbstractAction {
            public function execute()
            {
                
            }
        };

        $this->collection->push($action);
        $this->assertEquals($this->collection->pop(), $action);

        $this->expectException(\InvalidArgumentException::class);
        $this->collection->push('Non-action value');
    }
}
