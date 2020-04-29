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
        // Кажется это уже не используется
        return [
            'request' => '\Bizprofi\Monitoring\Actions\Http\Request',
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
            throw new \InvalidArgumentException('Unknown action type "'.$type.'"');
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

        if (array_key_exists('contextModifiers', $rawAction['action']) && is_array($rawAction['action']['contextModifiers'])) {
            foreach ($rawAction['action']['contextModifiers']['modifiers'] as $rawModifier) {
                echo 'Modifier: '.$rawModifier['type']."\n";
                $modifier = new $rawModifier['type']($rawModifier['data']);
                $action->addContextModifier($modifier);
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
