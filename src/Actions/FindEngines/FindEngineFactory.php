<?php

namespace PhpMetric\Actions\FindEngines;

use PhpMetric\AbstractEngine;

class FindEngineFactory
{
    protected static $entities = [
        'find' => [
            'element' => '\PhpMetric\Actions\FindEngines\Element',
            'elements' => '\PhpMetric\Actions\FindEngines\Elements',
            'attribute' => '\PhpMetric\Actions\FindEngines\Attribute',
            'string' => '\PhpMetric\Actions\FindEngines\Str',
        ],
        'request' => [
            'url' => '\PhpMetric\Actions\RequestEngines\Url',
            'status' => '\PhpMetric\Actions\RequestEngines\Status',
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
