<?php

namespace Bizprofi\Monitoring\Traits\Actions;

use Bizprofi\Monitoring\Actions\AbstractAction;
use Bizprofi\Monitoring\Collections\ActionCollection;
use Bizprofi\Monitoring\Interfaces\EnginableInterface;

trait Chainable
{
    protected $parentAction;

    protected $context = false;

    protected $childActions = false;

    /**
     * isChainable
     *
     * @return bool
     */
    public function isChainable(): bool
    {
        return true;
    }

    /**
     * setContext
     *
     * @param mixed $context
     * @return self
     */
    public function setContext($context)
    {
        $this->context = $context;
        if ($this instanceof EnginableInterface) {
            $this->getEngine()->setContext($context);
        }

        return $this;
    }

    /**
     * getContext
     *
     * @return mixed
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * addChildAction
     *
     * @param AbstractAction $action
     * @return self
     */
    public function addChildAction(AbstractAction $action)
    {
        if (!$this->childActions) {
            $this->initCollection();
        }

        $this->childActions->push($action);

        return $this;
    }

    public function getChildActions()
    {
        if (!$this->childActions) {
            $this->initCollection();
        }

        return $this->childActions;
    }

    protected function initCollection()
    {
        $this->childActions = new ActionCollection();
        $this->childActions->setParentAction($this);
    }

    // public function addChildLoopAction()
}
