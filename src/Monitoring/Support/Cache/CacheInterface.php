<?php

namespace Bizprofi\Monitoring\Support\Cache;

interface CacheInterface
{
    public function get(string $code, $default = null);

    public function set(string $code, $data);
}
