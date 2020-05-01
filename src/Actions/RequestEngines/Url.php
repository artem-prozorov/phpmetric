<?php

namespace PhpMetric\Actions\RequestEngines;

use PhpMetric\Traits\Http\CanMakeRequests;
use PhpMetric\Interfaces\EngineInterface;
use PhpMetric\Logs\{Info, Error};
use PhpMetric\AbstractEngine;

class Url extends AbstractEngine
{
    use CanMakeRequests;

    public function __construct()
    {

    }

    public function find($needle)
    {
        
    }

    public function setContext($context)
    {
        
    }
}
