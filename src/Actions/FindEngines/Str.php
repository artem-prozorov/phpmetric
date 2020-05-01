<?php

namespace PhpMetric\Actions\FindEngines;

use PhpMetric\AbstractEngine;
use PhpMetric\Interfaces\EngineInterface;

class Str extends AbstractEngine
{
    public function __construct($context)
    {
        $this->setContext($context);
    }

    /**
     * find
     *
     * @param string $needle
     * @return string
     */
    public function find($needle)
    {
        $pos = strpos($this->context, $needle);
        if ($pos === false) {
            return false;
        }

        return substr($this->context, $pos, strlen($needle));
    }
}