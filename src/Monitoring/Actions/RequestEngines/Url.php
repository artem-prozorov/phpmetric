<?php

namespace Bizprofi\Monitoring\Actions\RequestEngines;

use Bizprofi\Monitoring\Traits\Http\CanMakeRequests;
use Bizprofi\Monitoring\Interfaces\EngineInterface;
use Bizprofi\Monitoring\Logs\{Info, Error};
use Bizprofi\Monitoring\AbstractEngine;

class Url extends AbstractEngine
{
    use CanMakeRequests;

    public function __construct()
    {
        // $this->initClient();
    }

    public function find($needle)
    {
        
    }

    public function setContext($context)
    {
        
    }

    // public function setClient($client)
    // {
    //     $this->client = $client;
    // }

    // public function getClient()
    // {
    //     return $this->client;
    // }
}
