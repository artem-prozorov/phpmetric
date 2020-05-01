<?php

namespace PhpMetric\Actions\Context\Modifiers;

use PhpMetric\Actions\Context\AbstractModifier;

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
