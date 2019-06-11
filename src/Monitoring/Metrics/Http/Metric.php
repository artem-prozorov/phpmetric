<?php

namespace Bizprofi\Monitoring\Metrics\Http;

use Bizprofi\Monitoring\AbstractMetric;
use Bizprofi\Monitoring\Logs\Error;

class Metric extends AbstractMetric
{
    protected $actions;

    public function __construct(array $config = null)
    {
        parent::__construct();
    }

    // Здесь нужно реализовать метод checkRequiredFields,
    // который будет проверять является ли $this->config['actions']
    // экземпляром класса ActionsCollection

    public function execute() : self
    {
        try {
            parent::execute();

            if (empty($this->config['actions'])) {
                throw new \InvalidArgumentException('No actions provided');
            }

            // $this->config['actions'] должен быть экземпляром класса ActionsCollection,
            // у которого должен быть метод execute(), 
            // который выполнит все цепочки действий
            foreach ($this->config['actions'] as $action) {
                $actionResult = $action->execute();
                // if ($action->) {

                // }
            }
        } catch (\InvalidArgumentException $e) {
            $this->fail(new Error($e->getMessage()));
        }

        return $this;
    }
}
