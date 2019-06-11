<?php

namespace Bizprofi\Monitoring\Actions;

use Bizprofi\Monitoring\Actions\AbstractAction;

class ActionManager
{
    /**
     * getAction
     *
     * @return array
     */
    public static function getActions(): array
    {
        return [
            'Request' => '\Bizprofi\Monitoring\Actions\Http\Request',
            'find' => '\Bizprofi\Monitoring\Actions\Find',
            'cycle' => '\Bizprofi\Monitoring\Actions\Cycle',
        ];
    }

    /**
     * getAction
     *
     * @param string $type
     * @return string
     */
    public static function getAction(string $type): string
    {
        if (!array_key_exists($type, static::getActions())) {
            throw new \InvalidArgumentException('Unknown action type');
        }

        return static::getActions()[$type];
    }

    /**
     * wakeUp
     *
     * @param mixed $data
     * @return AbstractAction
     */
    public static function wakeUp($data): AbstractAction
    {
        if (is_array($data)) {
            return static::wakeUpFromArray($data);
        }

        return static::wakeUpFromJson($data);
    }

    /**
     * wakeUpFromArray
     *
     * @param array $rawAction
     * @return AbstractAction
     */
    public static function wakeUpFromArray(array $rawAction): AbstractAction
    {
        $class = static::getAction($rawAction['type']);
        $action = $class::createFromArray($rawAction['action']);
        if (array_key_exists('childActions', $rawAction['action']) && is_array($rawAction['action']['childActions'])) {
            foreach ($rawAction['action']['childActions'] as $rawSubAction) {
                $subaction = static::wakeUpFromArray($rawSubAction);
                $action->addChildAction($subaction);
            }
        }

        return $action;
    }

    /**
     * wakeUpFromJson
     *
     * @param string $json
     * @return AbstractAction
     */
    public static function wakeUpFromJson(string $json): AbstractAction
    {
        $rawAction = json_decode($json, true);
        if ($rawAction === false) {
            throw new \InvalidArgumentException('Cannot wake action up');
        }

        return static::wakeUpFromArray($rawAction);
    }
}
