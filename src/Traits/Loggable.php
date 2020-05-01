<?php

namespace PhpMetric\Traits;

use PhpMetric\Logs\Log;

trait Loggable
{
    protected $logs;

    /**
     * addLog
     *
     * @param Logs\Log $log
     * @return void
     */
    protected function addLog(Log $log)
    {
        $this->logs[] = $log;
    }

    /**
     * getLogs
     *
     * @return array
     */
    public function getLogs()
    {
        return $this->logs;
    }
}
