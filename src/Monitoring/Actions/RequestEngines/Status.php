<?php

namespace Bizprofi\Monitoring\Actions\RequestEngines;

use Bizprofi\Monitoring\Traits\Http\CanMakeRequests;
use Bizprofi\Monitoring\Interfaces\EngineInterface;
use Bizprofi\Monitoring\Logs\{Info, Error};
use Bizprofi\Monitoring\AbstractEngine;

class Status extends AbstractEngine
{
    use CanMakeRequests;

    public function __construct()
    {
        $this->method = 'HEAD';
    }

    public function find($needle)
    {
        
    }

    /**
     * makeRequest
     *
     * @param string $url
     * @return Status
     */
    public function makeRequest(string $url = null): Status
    {
        if (empty($url)) {
            $url = $this->context;
        }

        try {
            $response = $this->getClient()->request($this->method, $url, $this->params);
            $this->response = $response->getStatusCode();
        } catch (\Exception $e) {
            // var_dump($e->getMessage());
            // var_dump('fail loading url: '.$url);
        }

        return $this;
    }
}
