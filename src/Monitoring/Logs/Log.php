<?php

namespace Bizprofi\Monitoring\Logs;

use Bizprofi\Monitoring\Interfaces\Arrayable as ArrayableInterface;
use Bizprofi\Monitoring\Traits\Arrayable;

class Log implements ArrayableInterface
{
    use Arrayable;

    public const TYPE = 'LOG';

    /**
     * $message
     *
     * @var string $message
     */
    protected string $message;

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
        return $this->getType() . ': '.$this->message;
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

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'type' => $this->getType(),
            'message' => $this->getMessage(),
        ];
    }
}
