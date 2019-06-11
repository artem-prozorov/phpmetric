<?php

namespace Bizprofi\Monitoring\Logs;

class Log
{
    const TYPE = 'LOG';

    /**
     * $message
     *
     * @var string
     */
    protected $message;

    public function __construct(string $message = null)
    {
        if (!empty($message)) {
            $this->message = $message;
        }
    }

    /**
     * getMessage
     *
     * @return string
     */
    public function getMessage() : string
    {
        return $this->message;
    }

    /**
     * __toString
     *
     * @return string
     */
    public function __toString() : string
    {
        return $this->getType().': '.$this->message;
    }

    /**
     * getType
     *
     * @return string
     */
    public function getType()
    {
        return static::TYPE;
    }
}
