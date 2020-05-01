<?php

namespace PhpMetric\Tools;

use Symfony\Component\DomCrawler\Crawler;

class Type
{
    public static function stringify($data) : string
    {
        if (is_string($data)) {
            return $data;
        }

        if ($data instanceof Crawler) {
            $data = $data->html();
            return $data;
        }
    }
}
