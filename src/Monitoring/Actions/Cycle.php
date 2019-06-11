<?php

namespace Bizprofi\Monitoring\Actions;

use Bizprofi\Monitoring\Traits\Http\CanParseHtml;
use Bizprofi\Monitoring\Actions\{AbstractAction, ActionResult};
use Bizprofi\Monitoring\Logs\{Info, Error};
use Bizprofi\Monitoring\Traits\Actions\Chainable;
use Bizprofi\Monitoring\Actions\FindEngines\FindEngineFactory;
use Bizprofi\Monitoring\Actions\ActionManager;
use Bizprofi\Monitoring\Exceptions\{FatalActionException, WarningActionException};
use Bizprofi\Monitoring\Interfaces\ChainableInterface;

class Cycle extends AbstractAction implements ChainableInterface
{
    use Chainable;

    /**
     * $type
     *
     * @var string
     */
    protected $type = "cycle";

    protected $foreachableAction;

    /**
     * __construct
     *
     * @param AbstractAction $action
     * @param mixed $context
     * @param string $level
     * @return void
     */
    public function __construct(AbstractAction $action, $context = null, string $level = null)
    {
        parent::__construct($level);

        if (!empty($context)) {
            $this->setContext($context);
        }

        $this->setForeachableAction($action);
    }

    /**
     * setForeachableAction
     *
     * @param AbstractAction $action
     * @return self
     */
    public function setForeachableAction(AbstractAction $action): self
    {
        $this->foreachableAction = $action;

        return $this;
    }

    /**
     * execute
     *
     * @return self
     */
    public function execute() : self
    {
        foreach ($this->getContext() as $contextItem) {
            try {
                $this->foreachableAction->setContext($contextItem);
                $this->foreachableAction->getResult()->resetLogs();
                $this->foreachableAction->execute();
                $this->result->addLogs($this->foreachableAction->getResult()->getLogs());

                try {
                    if ($this->foreachableAction->getChildActions() && !$this->foreachableAction->getChildActions()->isEmpty()) {
                        $this->foreachableAction->getChildActions()->execute();
                        $this->result->addLogs($this->foreachableAction->getResult()->getLogs());
                    }
                } catch (WarningActionException $e) {
                    $this->addWarning($e);
                }
            } catch (WarningActionException $e) {
                $this->addWarning($e);
            } catch (\Exception $e) {
                $this->fail($e);
            }
        }

        return $this;
    }

    public function jsonSerialize(): array
    {
        $data = parent::jsonSerialize();
        $data['action']['action'] = $this->foreachableAction;
        $data['action']['context'] = $this->context;
        $data['action']['level'] = $this->level;
        $data['action']['childActions'] = $this->childActions;

        return $data;
    }

    /**
     * createFromArray
     *
     * @param array $data
     * @return Cycle
     */
    public static function createFromArray(array $data): Cycle
    {
        $foreachable = ActionManager::wakeUp($data['action']);
        $action = new Cycle($foreachable, $data['context'], $data['level']);

        return $action;
    }
}
