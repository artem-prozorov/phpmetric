<?php

namespace Bizprofi\Monitoring\Collections;

class Collection extends \SplQueue implements \JsonSerializable
{
    /**
     * jsonSerialize.
     *
     * @access	public
     * @return	array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

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
            $data[] = $item;
        }

        return $data;
    }
}
