<?php

namespace PhpMetric;

use PhpMetric\Traits\Singleton;

class ServiceProvider
{
    use Singleton;

    protected $services = [
        'Crawler' => '',
    ];

    public function getService(string $serviceName)
    {
        if (!array_key_exists($serviceName, $this->services)) {
            throw new \UnexpectedValueException('Unknown service provider is requested');
        }

        
    }
}
