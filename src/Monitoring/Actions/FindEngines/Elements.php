<?php

namespace Bizprofi\Monitoring\Actions\FindEngines;

use Symfony\Component\DomCrawler\Crawler;

class Elements extends Element
{
    protected function getFindResult($needle)
    {
        $result = $this->crawler->filter($needle)->each(function (Crawler $node, $i) {
            $element = $node->getNode(0);
            return $element->ownerDocument->saveHTML($element);
        });

        if (empty($result)) {
            throw new \InvalidArgumentException('Unable to find node');
        }

        return $result;
    }
}