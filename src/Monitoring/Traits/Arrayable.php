<?php

namespace Bizprofi\Monitoring\Traits;

use Bizprofi\Monitoring\Logs\Log;

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
