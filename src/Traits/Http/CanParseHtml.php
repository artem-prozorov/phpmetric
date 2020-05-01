<?php

namespace PhpMetric\Traits\Http;

use Symfony\Component\DomCrawler\Crawler;

trait CanParseHtml
{
    /**
     * $crawler
     *
     * @var mixed
     */
    protected $crawler;

    /**
     * $html
     *
     * @var string
     */
    protected $html;

    /**
     * initCrawler
     *
     * @param mixed $crawler
     * @return self
     */
    public function initCrawler($crawler = null) : self
    {
        if (empty($crawler)) {
            $this->crawler = new Crawler();
        } else {
            $this->crawler = $crawler;
        }

        return $this;
    }

    /**
     * clearCrawler
     *
     * @return self
     */
    public function clearCrawler()
    {
        if (empty($this->crawler)) {
            return $this;
        }

        $this->crawler->clear();

        return $this;
    }

    /**
     * setHtml
     *
     * @param string $html
     * @return self
     */
    public function setHtml(string $html) : self
    {
        $this->html = $html;

        return $this;
    }

    /**
     * getHtml
     *
     * @return string
     */
    public function getHtml() : string
    {
        return $this->html;
    }

    
    /**
     * parse
     *
     * @return mixed
     */
    public function parse()
    {
        if (empty($this->html)) {
            throw new \BadMethodCallException('No html to parse');
        }

        $this->getCrawler()->addContent($this->html, 'text/html');

        return $this->crawler;
    }

    /**
     * getCrawler
     *
     * @return mixed
     */
    public function getCrawler()
    {
        if (empty($this->crawler)) {
            $this->initCrawler();
        }

        return $this->crawler;
    }
}
