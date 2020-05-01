<?php

namespace PhpMetric\Interfaces;

use JsonSerializable;

interface Arrayable extends JsonSerializable
{
    public function toArray(): array;
}
