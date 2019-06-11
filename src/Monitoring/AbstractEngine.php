<?php

namespace Bizprofi\Monitoring;

use Bizprofi\Monitoring\Interfaces\EngineInterface;

abstract class AbstractEngine implements EngineInterface
{
    protected $context;

    public function setContext($context)
    {
        $this->context = $context;
    }

    abstract public function find($needle);
}
