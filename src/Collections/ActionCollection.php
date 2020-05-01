<?php

namespace PhpMetric\Collections;

use PhpMetric\Actions\AbstractAction;
use PhpMetric\Exceptions\ActionException;
use PhpMetric\Exceptions\WarningActionException;
use PhpMetric\Exceptions\FatalActionException;

class ActionCollection extends Collection implements \JsonSerializable
{
    protected $parentAction;

    /**
     * setParentAction
     *
     * @param AbstractAction $parentAction
     * @return void
     */
    public function setParentAction(AbstractAction $parentAction)
    {
        $this->parentAction = $parentAction;
    }

    public function execute()
    {
        foreach ($this as $action) {
            try {
                $action->setContext($this->parentAction->getResult()->getData());
                $action->execute();
                $this->parentAction->getResult()->addLogs($action->getResult()->getLogs());
            } catch (WarningActionException $e) {
                $this->parentAction->getResult()->addLogs($action->getResult()->getLogs());
            } catch (FatalActionException $e) {
                $this->parentAction->getResult()->addLogs($action->getResult()->getLogs());
                $this->parentAction->fail();
            }
        }
    }

    /**
     * push
     *
     * @param mixed $action
     * @return void
     */
    public function push($action)
    {
        if (!($action instanceof AbstractAction)) {
            $msg = 'You can only add only classes that extends AbstractAction class';
            throw new \InvalidArgumentException($msg);
        }

        parent::push($action);
    }

    /**
     * JsonSerializable
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        $array = [];
        foreach ($this as $action) {
            $array[] = $action;
        }

        return $array;
    }
}
