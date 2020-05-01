<?php

namespace PhpMetric\Traits\Actions;

use PhpMetric\Interfaces\EngineInterface;
use PhpMetric\Actions\FindEngines\FindEngineFactory;

trait Enginable
{
    /**
     * $identifier
     *
     * @var boolean
     */
    protected $identifier = false;

    /**
     * $code
     *
     * @var string
     */
    protected $code;

    /**
     * $engine (mainly for the testing purposes)
     *
     * @var mixed
     */
    protected $engine = false;

    /**
     * initEngine
     *
     * @param string $code
     * @param string $identifier
     * @return self
     */
    public function initEngine(string $code = null, string $identifier = null)
    {
        if (!empty($code)) {
            $this->setCode($code);
        }

        if (!empty($identifier)) {
            $this->setIdentifier($identifier);
        }

        return $this;
    }

    /**
     * setEngine
     *
     * @param EngineInterface $engine
     * @return self
     */
    public function setEngine($engine)
    {
        $this->engine = $engine;

        return $this;
    }

    /**
     * setCode
     *
     * @param string $code
     * @return self
     */
    public function setCode(string $code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * setIdentifier
     *
     * @param string $identifier
     * @return self
     */
    public function setIdentifier(string $identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * getCode
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * getIdentifier
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * getEngine
     *
     * @return mixed
     */
    public function getEngine()
    {
        if ($this->engine !== false) {
            return $this->engine;
        }

        if (empty($this->code)) {
            throw new \BadMethodCallException('Engine is not initialized: empty code: '.$this->code);
        }

        // if (empty($this->identifier)) {
        //     throw new \BadMethodCallException('Engine is not initialized: empty identifier');
        // }

        if (empty($this->type)) {
            throw new \BadMethodCallException('Engine is not initialized: empty type');
        }

        $engine = FindEngineFactory::getEngine($this->type, $this->code, $this->identifier, $this->context);

        $this->setEngine($engine);

        return $engine;
    }
}
