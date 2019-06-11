<?php

namespace Bizprofi\Monitoring\Traits;

trait Singleton
{
    /**
     * $instance
     *
     * @var self
     */
    protected static $instance = false;

    /**
     * getInstance
    *
    * @return self
    */
    final public static function getInstance()
    {
        if (static::$instance !== false) {
            return static::$instance;
        }

        return new static;
    }

    final private function __construct() {
        $this->init();
    }

    protected function init() {

    }

    final private function __wakeup()
    {

    }

    final private function __clone()
    {

    }   
}
