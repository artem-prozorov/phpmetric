<?php

namespace PhpMetric\Interfaces;

interface EngineInterface
{
    public function find($needle);

    public function setContext($context);
}
