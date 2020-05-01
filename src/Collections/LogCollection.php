<?php

namespace PhpMetric\Collections;

class LogCollection extends Collection
{
    /**
     * getLogMessages.
     *
     * @access	public
     * @return	array
     */
    public function getLogMessages(): array
    {
        $messages = [];
        foreach ($this as $log) {
            $messages[] = $log->__toString();
        }

        return $messages;
    }

    /**
     * @inheritDoc
     */
    protected function itemToArray($item)
    {
        return $item->toArray();
    }
}
