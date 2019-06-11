<?php

namespace Bizprofi\Monitoring\Actions;

use Bizprofi\Monitoring\Traits\Http\CanParseHtml;
use Bizprofi\Monitoring\Actions\{AbstractAction, ActionResult};
use Bizprofi\Monitoring\Logs\{Info, Error};
use Bizprofi\Monitoring\Traits\Actions\{Chainable, Enginable};
use Bizprofi\Monitoring\Actions\FindEngines\FindEngineFactory;
use Bizprofi\Monitoring\Interfaces\{ChainableInterface, EnginableInterface};

class Find extends AbstractAction implements ChainableInterface, EnginableInterface
{
    use Chainable, Enginable;

    /**
     * $type
     *
     * @var string
     */
    protected $type = "find";

    // Возможно можно удалить
    protected $search = false;

    /**
     * __construct
     *
     * @param string $code
     * @param string $identifier
     * @param mixed $context
     * @return void
     */
    public function __construct(string $code = null, string $identifier = null, $context = null, string $level = null)
    {
        parent::__construct($level);

        // Вместо этого говна сделать EngineFactory
        $this->entities = [
            'string' => '\Bizprofi\Monitoring\Actions\FindEngines\Str',
            'element' => '\Bizprofi\Monitoring\Actions\FindEngines\Element',
            'elements' => '\Bizprofi\Monitoring\Actions\FindEngines\Elements',
            'attribute' => '\Bizprofi\Monitoring\Actions\FindEngines\Attribute',
        ];

        $this->initEngine($code, $identifier);

        // Возможно, нужно перенести в трайт Chainable
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
        try {
            // $this->getEngine()->setContext($this->context);
            // var_dump('Trying to find needle '.$this->code.' '.$this->identifier.
            // ' in context: '.$this->context);
            $findResult = $this->getEngine()->find($this->identifier);
            // $this->getEngine()->clearCrawler();
            if ($findResult === false) {
                throw new \OutOfBoundsException(
                    'Cannot find needle '.$this->code.' '.$this->identifier.
                    ' in context: '.$this->context
                );
            }

            $this->result->setData($findResult);
            $this->result->addLog(new Info(
                'Needle '.$this->code.' '.$this->identifier.
                ' FOUND in context: '.$this->context
            ));

            $this->executeChild();
        } catch (\OutOfBoundsException $e) {
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
        $data['action']['identifier'] = $this->identifier;
        $data['action']['context'] = $this->context;
        $data['action']['childActions'] = $this->childActions;

        return $data;
    }

    /**
     * createFromArray
     *
     * @param array $data
     * @return Find
     */
    public static function createFromArray(array $data): Find
    {
        $action = new Find($data['code'], $data['identifier'], $data['context']);
        $action->setLevel($data['level']);

        return $action;
    }
}
