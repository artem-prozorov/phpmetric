<?php

namespace PhpMetric\Interfaces;

use PhpMetric\Actions\AbstractAction;

interface ChainableInterface
{
    public function isChainable(): bool;

    public function setContext($context);

    public function getContext();

    public function addChildAction(AbstractAction $action);

    public function getChildActions();
}
