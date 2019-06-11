<?php

namespace Bizprofi\Monitoring\Actions;

use Bizprofi\Monitoring\Interfaces\Actions\ActionInterface;
use Bizprofi\Monitoring\Logs\{Error, Warning};
use Bizprofi\Monitoring\Exceptions\ActionException;
use \Bizprofi\Monitoring\Exceptions\FatalActionException;
use \Bizprofi\Monitoring\Exceptions\WarningActionException;

abstract class AbstractAction implements ActionInterface
{
    const WARNING = 'W';

    const FATAL = 'F';

    /**
     * $type
     *
     * @var string
     */
    protected $type;

    /**
     * $result
     *
     * @var ActionResult
     */
    protected $result;

    /**
     * $level
     *
     * @var string
     */
    protected $level;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct(string $level = null)
    {
        if (empty($level)) {
            $this->level = static::FATAL;
        } else {
            $this->setLevel($level);
        }

        $this->result = new ActionResult();

        if (empty($this->type)) {
            $path = explode('\\', get_called_class());
            $this->type = array_pop($path);
        }
    }

    /**
     * jsonSerialize
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
            'action' => [
                'level' => $this->level,
                'chainable' => $this->isChainable(),
            ]
        ];
    }

    /**
     * getLevels
     *
     * @return array
     */
    public static function getLevels() : array
    {
        return [
            'Warning' => static::WARNING,
            'Fatal' => static::FATAL,
        ];
    }

    public function getLevel(): string
    {
        return $this->level;
    }

    /**
     * setLevel
     *
     * @param string $level
     * @return self
     */
    public function setLevel(string $level): self
    {
        if (!in_array($level, static::getLevels(), true)) {
            throw new \InvalidArgumentException('Invalid level');
        }

        $this->level = $level;

        return $this;
    }

    /**
     * Alias for setLevel()
     *
     * @return self
     */
    public function warning(): self
    {
        return $this->setLevel(static::WARNING);
    }

    /**
     * getResult
     *
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * isChainable
     *
     * @return boolean
     */
    public function isChainable() : bool
    {
        return false;
    }

    /**
     * getContext
     *
     * @return boolean
     */
    public function getContext()
    {
        return false;
    }

    /**
     * fail
     *
     * @param mixed \Exception
     * @return void
     */
    public function fail(\Exception $exception = null)
    {
        $this->result->setSuccess(false);

        $message = empty($exception) ? null : $exception->getMessage();

        if ($this->level === static::WARNING) {
            if (!empty($exception)) {
                $this->result->addLog(new Warning($exception->getMessage()));
            }

            throw new WarningActionException($message);
        }

        if ($this->level === static::FATAL) {
            if (!empty($exception)) {
                $this->result->addError(new Error($exception->getMessage()));
            }

            throw new FatalActionException($message);
        }
    }

    /**
     * addWarning
     *
     * @param WarningActionException $exception
     * @return void
     */
    public function addWarning(WarningActionException $exception)
    {
        $this->result->addError(new Error($exception->getMessage()));
    }

    /**
     * createFromArray
     *
     * @param array $data
     * @return void
     */
    public static function createFromArray(array $data)
    {
        throw new \RuntimeException('Implement this method');
    }

    /**
     * executeChild
     *
     * @return void
     */
    public function executeChild(): void
    {
        if (!$this->childActions) {
            return;
        }

        if ($this->childActions->isEmpty()) {
            return;
        }

        $this->childActions->execute();
    }

    abstract public function execute();
}