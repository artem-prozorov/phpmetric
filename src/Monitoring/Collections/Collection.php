<?php

namespace Bizprofi\Monitoring\Collections;

use SplQueue;
use Bizprofi\Monitoring\Interfaces\Arrayable as ArrayableInterface;
use Bizprofi\Monitoring\Traits\Arrayable;

class Collection extends SplQueue implements ArrayableInterface
{
    use Arrayable;

    /**
     * toArray.
     *
     * @access	public
     * @return	mixed
     */
    public function toArray(): array
    {
        $data = [];

        foreach ($this as $item) {
            $data[] = $this->itemToArray($item);
        }

        return $data;
    }

    /**
     * itemToArray.
     *
     * @access	protected
     * @param	mixed	$item	
     * @return	mixed
     */
    protected function itemToArray($item)
    {
        return $item;
    }
}
