<?php

namespace Bizprofi\Monitoring\Tests;

use PHPUnit\Framework\TestCase;
use Bizprofi\Monitoring\Result;
use Bizprofi\Monitoring\Collections\LogCollection;
use Bizprofi\Monitoring\Logs\{Log, Error};

class ResultTest extends TestCase
{
    public function testConstructor()
    {
        $result = new Result();

        $this->assertTrue($result->isSuccess());
        $this->assertTrue($result->getLogs() instanceof LogCollection);
        $this->assertTrue($result->getLogs()->isEmpty());
    }

    public function testData()
    {
        $result = new Result();

        $data = 'Test';
        $result->setData($data);

        $this->assertEquals($result->getData(), $data);
    }

    public function testLogs()
    {
        $result = new Result();
        $log = new Log('Test log');
        $result->addLog($log);
        $this->assertTrue($result->isSuccess());

        $error = new Error('Test error');
        $result->addLog($error);
        $this->assertFalse($result->isSuccess());

        $collection = $result->getLogs();
        $this->assertEquals($collection[0], $log);
        $this->assertEquals($collection[1], $error);
    }

    public function testAddLogs()
    {
        $result = new Result();
        $collection = new LogCollection();
        $log = new Log('Test log');
        $error = new Error('Test error');
        $collection->push($log);
        $collection->push($error);

        $result->addLogs($collection);
        $this->assertEquals($collection[0], $result->getLogs()[0]);
        $this->assertEquals($collection[1], $result->getLogs()[1]);
    }
}
