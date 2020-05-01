<?php

namespace PhpMetric\Interfaces;

interface EnginableInterface
{
    public function initEngine(string $code = null, string $identifier = null);

    public function setEngine($engine);

    public function setCode(string $code);

    public function setIdentifier(string $identifier);

    public function getCode(): string;

    public function getIdentifier(): string;

    public function getEngine();
}
