<?php

namespace Bizprofi\Monitoring\Actions\Http;

use Bizprofi\Monitoring\Traits\Actions\{Chainable, Enginable};
use Bizprofi\Monitoring\Actions\AbstractAction;
use Bizprofi\Monitoring\Actions\ActionResult;
use Bizprofi\Monitoring\Logs\Error;

class Request extends AbstractAction
{
    use Chainable, Enginable;

    public function __construct(string $code = null, string $identifier = null, $context = null, string $level = null)
    {
        parent::__construct($level);

        // Перенести в трайт Chainable
        if (!empty($context)) {
            $this->setContext($context);
        }

        $this->initEngine($code, $identifier);

        $this->entities = [
            'url' => '\Bizprofi\Monitoring\Actions\RequestEngines\Url',
            // 'status' => '\Bizprofi\Monitoring\Actions\RequestEngines\Status',
        ];
    }

    /**
     * execute
     *
     * @return self
     */
    public function execute() : self
    {
        if (empty($this->identifier) && !$this->getContext()) {
            $this->identifier = $this->getContext();
        }

        if (!$this->engine) {
            $this->initEngine($this->code, $this->identifier);
        }

        try {
            $response = $this->getEngine()->makeRequest($this->identifier)->getResponse();
            $this->result->setData($response);
            $this->executeChild();
        } catch (\Exception $e) {
            $this->fail($e);
        }

        return $this;
    }

    /**
     * jsonSerialize
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        $data = parent::jsonSerialize();

        $data['action']['code'] = $this->code;
        $data['action']['identifier'] = $this->url;
        $data['action']['context'] = $this->params;
        $data['action']['level'] = $this->level;
        $data['action']['childActions'] = $this->childActions;

        return $data;
    }

    /**
     * createFromArray
     *
     * @param array $data
     * @return Request
     */
    public static function createFromArray(array $data): Request
    {
        $action = new Request($data['code'], $data['identifier'], $data['context'], $data['level']);

        return $action;
    }
}
