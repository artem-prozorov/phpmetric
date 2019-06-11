<?php

namespace Bizprofi\Monitoring\Tests\Logs;

use PHPUnit\Framework\TestCase;
use Bizprofi\Monitoring\Logs\Log;
use Bizprofi\Monitoring\Logs\Info;
use Bizprofi\Monitoring\Logs\Error;
use Bizprofi\Monitoring\Logs\Warning;

class LogTest extends TestCase
{
    public function testLog()
    {
        $log = new Log('Message');
        $this->assertEquals('Message', $log->getMessage());
        $this->assertEquals(Log::TYPE, $log->getType());
        $this->assertEquals(Log::TYPE.': Message', (string) $log);
    }

    public function testInfo()
    {
        $log = new Info('Message');
        $this->assertEquals('Message', $log->getMessage());
        $this->assertEquals(Info::TYPE, $log->getType());
        $this->assertEquals(Info::TYPE.': Message', (string) $log);
    }

    public function testError()
    {
        $log = new Error('Message');
        $this->assertEquals('Message', $log->getMessage());
        $this->assertEquals(Error::TYPE, $log->getType());
        $this->assertEquals(Error::TYPE.': Message', (string) $log);
    }

    public function testWarning()
    {
        $log = new Warning('Message');
        $this->assertEquals('Message', $log->getMessage());
        $this->assertEquals(Warning::TYPE, $log->getType());
        $this->assertEquals(Warning::TYPE.': Message', (string) $log);
    }
}
