<?php

namespace Bizprofi\Monitoring\Actions\FindEngines;

class FindEngineFactory
{
    protected static $entities = [
        'string' => '\Bizprofi\Monitoring\Actions\FindEngines\Str',
        'element' => '\Bizprofi\Monitoring\Actions\FindEngines\Element',
        'elements' => '\Bizprofi\Monitoring\Actions\FindEngines\Elements',
        'attribute' => '\Bizprofi\Monitoring\Actions\FindEngines\Attribute',
    ];

    public static function getEngine(string $code, string $identifier, $context)
    {
        if (!array_key_exists($code, static::$entities)) {
            throw new \InvalidArgumentException('Unknown action code');
        }

        return new static::$entities[$code]($context);
    }
}
