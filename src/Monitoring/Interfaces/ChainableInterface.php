<?php

namespace Bizprofi\Monitoring\Interfaces;

use Bizprofi\Monitoring\Actions\AbstractAction;

interface ChainableInterface
{
    public function isChainable(): bool;

    public function setContext($context);

    public function getContext();

    public function addChildAction(AbstractAction $action);

    public function getChildActions();
}
