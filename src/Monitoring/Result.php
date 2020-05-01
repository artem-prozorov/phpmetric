<?php

namespace Bizprofi\Monitoring;

use Bizprofi\Monitoring\Logs\{Log, Error};
use Bizprofi\Monitoring\Collections\LogCollection;
use Bizprofi\Monitoring\Interfaces\Arrayable as ArrayableInterface;
use Bizprofi\Monitoring\Traits\Arrayable;

class Result implements ArrayableInterface
{
    use Arrayable;

    /**
     * $data
     *
     * @var mixed
     */
    protected $data;

    /**
     * $errors
     *
     * @var LogCollection
     */
    protected $logs;

    /**
     * $isSuccess
     *
     * @var bool
     */
    protected $isSuccess;

    public function __construct()
    {
        $this->isSuccess = true;
        $this->logs = new LogCollection();
    }

    /**
     * setData
     *
     * @param mixed $data
     * @return self
     */
    public function setData($data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    /**
     * isSuccess
     *
     * @return boolean
     */
    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }

    public function addError(Error $error)
    {
        $this->isSuccess = false;
        $this->logs->push($error);

        return $this;
    }

    public function addLog(Log $log)
    {
        if ($log instanceof Error) {
            $this->addError($log);
        } else {
            $this->logs->push($log);
        }

        return $this;
    }

    /**
     * getLogs
     *
     * @return LogCollection
     */
    public function getLogs(): LogCollection
    {
        return $this->logs;
    }

    /**
     * addLogs
     *
     * @param LogCollection $logs
     * @return self
     */
    public function addLogs(LogCollection $logs): self
    {
        foreach ($logs as $log) {
            $this->logs->push($log);
        }

        return $this;
    }

    /**
     * getLogMessages
     *
     * @return array
     */
    public function getLogMessages(): array
    {
        return $this->logs->getLogMessages();
    }

    /**
     * setSuccess
     *
     * @param bool $success
     * @return self
     */
    public function setSuccess(bool $success): self
    {
        $this->isSuccess = $success;

        return $this;
    }

    /**
     * resetLogs
     *
     * @return self
     */
    public function resetLogs(): self
    {
        unset($this->logs);
        $this->logs = new LogCollection();
        
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'success' => $this->isSuccess(),
            'logs' => $this->getLogs()->toArray(),
        ];
    }
}
