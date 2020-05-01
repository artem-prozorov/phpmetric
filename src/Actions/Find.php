<?php

namespace PhpMetric\Actions;

use PhpMetric\Traits\Http\CanParseHtml;
use PhpMetric\Actions\{AbstractAction, ActionResult};
use PhpMetric\Logs\{Info, Error};
use PhpMetric\Traits\Actions\{Chainable, Enginable};
use PhpMetric\Actions\FindEngines\FindEngineFactory;
use PhpMetric\Interfaces\{ChainableInterface, EnginableInterface};
use PhpMetric\Exceptions\FindException;
use PhpMetric\Language\Language;

class Find extends AbstractAction implements ChainableInterface, EnginableInterface
{
    use Chainable, Enginable;

    /**
     * $type
     *
     * @var string
     */
    protected $type = "find";

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
        Language::setLocale('Ru');
        Language::loadFile('find_action');

        try {
            $findResult = $this->getEngine()->find($this->identifier);
            $langParams = ['CODE' => $this->code, 'IDENTIFIER' => $this->identifier, 'CONTEXT' => $this->context];
            if ($findResult === $this->negated) {
                $message = Language::get($this->negated ? 'NEGATED_NEEDLE_FOUND' : 'CANNOT_FIND_NEEDLE', $langParams);
                throw new FindException($message);
            }

            $this->result->setData($findResult);
            $message = Language::get('NEEDLE_FOUND', $langParams);
            $this->result->addLog(new Info(Language::get('NEEDLE_FOUND', $langParams)));

            $this->executeChild();
        } catch (FindException $e) {
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
        if (isset($data['negated']) && $data['negated'] === true) {
            $action->negate();
        }

        return $action;
    }
}
