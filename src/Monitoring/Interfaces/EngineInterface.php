<?php

namespace Bizprofi\Monitoring\Interfaces;

interface EngineInterface
{
    public function find($needle);

    public function setContext($context);
}
