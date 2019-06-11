<?php

namespace Bizprofi\Monitoring\Collections;

class LogCollection extends Collection
{
    public function getLogMessages(): array
    {
        $messages = [];
        foreach ($this as $log) {
            $messages[] = $log->__toString();
        }

        return $messages;
    }
}
