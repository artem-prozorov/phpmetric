<?php

namespace PhpMetric\Interfaces\Actions;

interface ActionInterface extends \JsonSerializable
{
    public function execute();
    
    public function getResult();

    public function getLevel();
}
