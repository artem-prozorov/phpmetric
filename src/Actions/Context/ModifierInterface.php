<?php

namespace PhpMetric\Actions\Context;

interface ModifierInterface extends \JsonSerializable
{
    public function __construct($data);

    public function apply($context);
}
