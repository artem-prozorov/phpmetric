<?php

namespace PhpMetric\Actions\Http;

use PhpMetric\Traits\Actions\{Chainable, Enginable};
use PhpMetric\Actions\AbstractAction;
use PhpMetric\Actions\ActionResult;
use PhpMetric\Logs\Error;
use PhpMetric\Interfaces\{ChainableInterface, EnginableInterface};

class Request extends AbstractAction implements ChainableInterface, EnginableInterface
{
    use Chainable, Enginable;

    /**
     * $type
     *
     * @var string
     */
    protected $type = 'request';

    public function __construct(string $code = null, string $identifier = null, $context = null, string $level = null)
    {
        parent::__construct($level);

        $this->initEngine($code, $identifier);

        if (!empty($context)) {
            $this->setContext($context);
        }
    }

    /**
     * execute
     *
     * @return self
     */
    public function execute() : self
    {
        if ($this->getContext()) {
            $this->identifier = $this->getContext();
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
    // public function jsonSerialize(): array
    // {
    //     $data = parent::jsonSerialize();

    //     $data['action']['code'] = $this->code;
    //     $data['action']['identifier'] = $this->identifier;
    //     $data['action']['context'] = $this->context;
    //     $data['action']['level'] = $this->level;
    //     $data['action']['childActions'] = $this->childActions;

    //     return $data;
    // }

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
