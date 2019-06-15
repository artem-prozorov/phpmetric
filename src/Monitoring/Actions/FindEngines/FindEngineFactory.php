<?php

namespace Bizprofi\Monitoring\Actions\FindEngines;

use Bizprofi\Monitoring\AbstractEngine;

class FindEngineFactory
{
    protected static $entities = [
        'find' => [
            'element' => '\Bizprofi\Monitoring\Actions\FindEngines\Element',
            'elements' => '\Bizprofi\Monitoring\Actions\FindEngines\Elements',
            'attribute' => '\Bizprofi\Monitoring\Actions\FindEngines\Attribute',
            'string' => '\Bizprofi\Monitoring\Actions\FindEngines\Str',
        ],
        'request' => [
            'url' => '\Bizprofi\Monitoring\Actions\RequestEngines\Url',
            'status' => '\Bizprofi\Monitoring\Actions\RequestEngines\Status',
        ],
    ];

    /**
     * getEngine
     *
     * @param string $type
     * @param string $code
     * @param string $identifier
     * @param mixed $context
     * @return AbstractEngine
     */
    public static function getEngine(string $type, string $code, string $identifier, $context)
    {
        if (!isset(static::$entities[$type][$code])) {
            throw new \InvalidArgumentException('Unknown action type '.$type.' or code '.$code);
        }

        return new static::$entities[$type][$code]($context);
    }
}
