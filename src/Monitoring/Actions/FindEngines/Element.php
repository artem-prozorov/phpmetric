<?php

namespace Bizprofi\Monitoring\Actions\FindEngines;

use Bizprofi\Monitoring\Traits\Http\CanParseHtml;
use Bizprofi\Monitoring\Logs\{Info, Error};
use Bizprofi\Monitoring\Interfaces\EngineInterface;

class Element implements EngineInterface
{
    use CanParseHtml;

    public function __construct($context)
    {
        $this->setHtml($context);
    }

    /**
     * setContext
     *
     * @param mixed $context
     * @return EngineInterface
     */
    public function setContext($context)
    {
        // Для теста, удалить потом это говно
        $this->clearCrawler()->setHtml($context);

        // $this->setHtml($context);

        return $this;
    }

    /**
     * find
     *
     * @param string $needle
     * @return string
     */
    public function find($needle)
    {
        $this->parse();

        try {
            $result = $this->getFindResult($needle);
        } catch (\InvalidArgumentException $e) {
            $result = false;
        }

        return $result;
    }

    protected function getFindResult($needle)
    {
        if (!$node = $this->getCrawler()->filter($needle)->getNode(0)) {
            throw new \InvalidArgumentException('Unable to find node');
        }

        return $node->ownerDocument->saveHTML($node);
    }
}
