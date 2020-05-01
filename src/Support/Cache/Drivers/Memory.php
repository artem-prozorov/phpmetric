<?php

namespace PhpMetric\Support\Cache\Drivers;

use PhpMetric\Support\Cache\CacheInterface;
use PhpMetric\Traits\Singleton;

class Memory implements CacheInterface
{
    use Singleton;

    protected $data = [];

    public function set(string $code, $data)
    {
        $this->data[$code] = $data;
    }

    public function get(string $code, $default = null)
    {
        if (array_key_exists($code, $this->data)) {
            return $this->data[$code];
        }

        if (!empty($default)) {
            return $default;
        }

        return false;
    }
}
