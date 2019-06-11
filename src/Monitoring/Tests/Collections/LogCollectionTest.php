<?php

namespace Bizprofi\Monitoring\Tests\Collections;

use PHPUnit\Framework\TestCase;
use Bizprofi\Monitoring\Collections\LogCollection;
use Bizprofi\Monitoring\Logs\{Log, Warning, Error, Info};

class LogCollectionTest extends TestCase
{
    protected $collection;

    protected function setUp(): void
    {
        $this->collection = new LogCollection();
    }

    public function testPush()
    {
        $log = new Log('This is a test log');
        $warning = new Warning('This is a test warning');
        $error = new Error('This is a test error');
        $info = new Info('This is a test info');

        $this->collection->push($log);
        $this->collection->push($warning);
        $this->collection->push($error);
        $this->collection->push($info);

        $messages = $this->collection->getLogMessages();

        $this->assertEquals($messages[0], 'LOG: This is a test log');
        $this->assertEquals($messages[1], 'WARNING: This is a test warning');
        $this->assertEquals($messages[2], 'ERROR: This is a test error');
        $this->assertEquals($messages[3], 'INFO: This is a test info');
    }
}
