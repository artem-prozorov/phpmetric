<?php

namespace PhpMetric\Traits;

use PhpMetric\Logs\Log;

trait Arrayable
{
    /**
     * toArray.
     *
     * @access	public
     * @return	array
     */
    public function toArray(): array
    {
        return [];
    }

    /**
     * jsonSerialize.
     *
     * @access	public
     * @return	array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
