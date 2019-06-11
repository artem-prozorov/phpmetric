<?php

namespace Bizprofi\Monitoring;

use Bizprofi\Monitoring\Traits\Observerable;
use Bizprofi\Monitoring\Traits\Loggable;
use Bizprofi\Monitoring\Logs\Error;

abstract class AbstractMetric implements \SplSubject
{
    use Observerable;
    use Loggable;

    /**
     * $initialized
     *
     * @var boolean
     */
    protected $initialized = false;

    /**
     * $success
     *
     * @var boolean
     */
    protected $success = true;

    /**
     * $config
     *
     * @var array
     */
    protected $config = [];

    /**
     * $result
     *
     * @var mixed
     */
    protected $result;

    /**
     * $requiredParams
     *
     * @var array
     */
    protected $requiredParams = [];
    
    public function __construct(array $config = null)
    {
        if (!empty($config)) {
            $this->setConfig($config);
        }

        $this->initObservers();
    }

    /**
     * isInitialised
     *
     * @return boolean
     */
    public function isInitialised() : bool
    {
        return $this->initialized;
    }

    /**
     * isInitialised
     *
     * @return boolean
     */
    public function isSuccess() : bool
    {
        return $this->success;
    }

    /**
     * Metric config setter
     *
     * @param array $config
     * @return self
     */
    public function setConfig(array $config) : self
    {
        $this->checkRequiredFields($config);
        $this->config = $config;
        $this->initialized = true;

        return $this;
    }

    /**
     * checkRequiredFields
     *
     * @param array $config
     * @return self
     */
    protected function checkRequiredFields(array $config) : self
    {
        $unfiled = array_diff($this->requiredParams, array_keys($config));
        if (!empty($unfiled)) {
            throw new \InvalidArgumentException('Please provide the following parameters: '.implode(', ', $unfiled));
        }

        return $this;
    }

    public function execute()
    {
        if (!$this->initialized) {
            throw new \InvalidArgumentException('Trying to execute uninitialized metric');
        }
    }

    protected function fail(Error $error = null)
    {
        $this->success = false;

        if (!empty($error)) {
            $this->addLog($error);
        }
    }
}
