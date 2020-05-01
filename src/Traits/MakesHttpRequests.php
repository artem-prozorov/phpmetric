<?php

namespace Bizprofi\Tests\Traits;

use Bitrix\Main\Web\HttpClient;
use Symfony\Component\DomCrawler\Crawler;

trait MakesHttpRequests
{
    /**
     * HTTP Client to make requests
     *
     * @var HttpClient
     */
    protected $client;

    /**
     * Plain HTML response
     *
     * @var string
     */
    protected $html;

    /**
     * HTTP Response
     *
     * @var Crawler
     */
    protected $parsed;

    /**
     * Initializes tests
     *
     * @return void
     */
    protected function setUp()
    {
        $this->client = new HttpClient();
        $this->html = null;
        $this->parsed = null;
    }

    /**
     * Sends GET request to the provided URL and stores received HTML
     *
     * @param string $url
     * @return self
     */
    public function visit(string $url) : self
    {
        $this->html = $this->client->get($url);

        return $this;
    }

    /**
     * Parses plain HTML response (string) into Crawler object
     *
     * @return self
     */
    public function parse() : self
    {
        $this->parsed = new Crawler($this->html);

        return $this;
    }

    public function see(string $text) : self
    {
        // $this->
        return $this;
    }

    public function dontSee(string $text) : self
    {
        return $this;
    }
}
