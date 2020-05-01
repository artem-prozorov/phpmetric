<?php

namespace Bizprofi\Monitoring\Interfaces;

use JsonSerializable;

interface Arrayable extends JsonSerializable
{
    public function toArray(): array;
}
