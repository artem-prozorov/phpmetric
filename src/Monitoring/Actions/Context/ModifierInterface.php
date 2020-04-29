<?php

namespace Bizprofi\Monitoring\Actions\Context;

interface ModifierInterface extends \JsonSerializable
{
    public function __construct($data);

    public function apply($context);
}
