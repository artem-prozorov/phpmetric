<?php

namespace Bizprofi\Monitoring\Actions\FindEngines;

class Attribute extends Element
{
    protected function getFindResult($needle)
    {
        $tag = strtok(substr($this->html, 1), " ");
        $test = $this->crawler->getNode(0);
        // var_dump($test->getAttributeNS('descendant-or-self::'.$tag, "style"));

        // var_dump($this->getHtml());

        $result = $this->crawler->filterXPath('descendant-or-self::'.$tag)->attr($needle);
        if (empty($result)) {
            throw new \InvalidArgumentException('Unable to find node');
        }

        return $result;
    }
}