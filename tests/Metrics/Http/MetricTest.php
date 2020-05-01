<?php

namespace PhpMetric\Tests\Metrics\Http;

use PHPUnit\Framework\TestCase;
use PhpMetric\Metrics\Http\Metric as HttpMetric;

class MetricTest extends TestCase
{
    public function testEmptyConfig()
    {
        $metric = new HttpMetric();
        $this->assertEquals($metric->execute()->isSuccess(), false);
    }

    // public function testInvalidConfig()
    // {
        // $metric = new HttpMetric();

        // try {
        //     $metric->setConfig(['url' => '/']);
        // } catch (\InvalidArgumentException $e) {
        //     $this->assertEquals($e->getMessage(), 'Please provide the following parameters: actions');
        //     $this->assertEquals($metric->isInitialised(), false);
        // }

        // try {
        //     $metric->setConfig(['actions' => '/']);
        // } catch (\InvalidArgumentException $e) {
        //     $this->assertEquals($e->getMessage(), 'Please provide the following parameters: url');
        //     $this->assertEquals($metric->isInitialised(), false);
        // }
    // }

    public function testValidConfig()
    {
        $metric = new HttpMetric();
        $initialized = $metric->setConfig(['url' => '/', 'actions' => []])->isInitialised();
        $this->assertEquals($initialized, true);
    }

    public function testEmptyActions()
    {
        $metric = new HttpMetric();
        $metric->setConfig(['url' => '/', 'actions' => []]);
        $metric->execute();

        $this->assertEquals($metric->isSuccess(), false);
        $this->assertEquals((string) $metric->getLogs()[0], 'ERROR: No actions provided');
    }
}
