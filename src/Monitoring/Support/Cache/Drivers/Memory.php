<?php

namespace Bizprofi\Monitoring\Support\Cache\Drivers;

use Bizprofi\Monitoring\Support\Cache\CacheInterface;
use Bizprofi\Monitoring\Traits\Singleton;

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
