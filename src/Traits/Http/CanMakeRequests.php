<?php

namespace PhpMetric\Traits\Http;

use PhpMetric\Result;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

trait CanMakeRequests
{
    protected $client = false;

    /**
     * $response
     *
     * @var mixed
     */
    protected $response;

    /**
     * $method
     *
     * @var string
     */
    protected $method = 'GET';

    /**
     * $params
     *
     * @var array
     */
    protected $params = [];

    /**
     * initClient
     *
     * @param ClientInterface $httpClient
     * @return self
     */
    public function initClient(ClientInterface $httpClient = null) : self
    {
        if (empty($httpClient)) {
            $this->client = new Client();
        } else {
            $this->client = $httpClient;
        }

        return $this;
    }

    public function getClient()
    {
        if ($this->client === false) {
            $this->initClient();
        }

        return $this->client;
    }

    /**
     * setMethod
     *
     * @param string $method
     * @return self
     */
    public function setMethod(string $method) : self
    {
        $this->method = $method;

        return $this;
    }

    /**
     * getMethod
     *
     * @return string
     */
    public function getMethod() : string
    {
        return $this->method;
    }

    /**
     * setParams
     *
     * @param array $params
     * @return self
     */
    public function setParams(array $params) : self
    {
        $this->params = $params;

        return $this;
    }

    public function getParams()
    {
        return $this->params;
    }

    /**
     * makeRequest
     *
     * @param string $url
     * @return self
     */
    public function makeRequest(string $url) : self
    {
        $response = $this->getClient()->request($this->method, $url, $this->params);
        switch ($response->getStatusCode()) {
            case 200:
                break;
            default:
                throw new \UnexpectedValueException('Response status code is '.$response->getStatusCode());
        }

        $this->response = $response->getBody()->getContents();

        return $this;
    }

    /**
     * getResponse
     *
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }
}
