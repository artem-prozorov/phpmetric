<?php

namespace PhpMetric\Traits\Actions;

use PhpMetric\Actions\AbstractAction;
use PhpMetric\Collections\ActionCollection;
use PhpMetric\Interfaces\EnginableInterface;
use PhpMetric\Actions\Context\{ModifierCollection, ModifierInterface};

trait Chainable
{
    protected $parentAction;

    protected $context = false;

    protected $childActions = false;

    protected $contextModifiers = false;

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
        if ($this->contextModifiers !== false) {
            $context = $this->contextModifiers->apply($context);
        }

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

    /**
     * addContextModifier.
     *
     * @access	public
     * @param	modifierinterface	$modifier	
     * @return	self
     */
    public function addContextModifier(ModifierInterface $modifier)
    {
        if ($this->contextModifiers === false) {
            $this->contextModifiers = new ModifierCollection();
        }

        $this->contextModifiers->push($modifier);

        return $this;
    }

    /**
     * getContextModifiers.
     *
     * @access	public
     * @return	mixed
     */
    public function getContextModifiers()
    {
        return $this->contextModifiers;
    }
}
