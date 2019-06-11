<?php

namespace Bizprofi\Monitoring\Actions\FindEngines;

use Bizprofi\Monitoring\AbstractEngine;
use Bizprofi\Monitoring\Interfaces\EngineInterface;

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