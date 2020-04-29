<?php

namespace Bizprofi\Monitoring\Actions\Context\Modifiers;

use Bizprofi\Monitoring\Actions\Context\AbstractModifier;

class Url extends AbstractModifier
{
    public function apply($context)
    {
        if (!is_string($context)) {
            return $context;
        }

        if (strpos($context, 'http') !== 0) {
            $context = $this->data.$context;
        }

        return $context;
    }

    // public function jsonSerialize(): array;
    // {
    //     return [
    //         'type' => '\\Bizprofi\\Monitoring\\Actions\\Context\\Modifiers\\Url',
    //         'data' => $this->data,
    //     ];
    // }
}
