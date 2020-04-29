<?php

namespace Bizprofi\Monitoring\Actions\Context;

use Bizprofi\Monitoring\Collections\Collection;

class ModifierCollection extends Collection implements \JsonSerializable
{
    public function apply($context)
    {
        foreach ($this as $modifier) {
            $context = $modifier->apply($context);
        }

        return $context;
    }

    /**
     * jsonSerialize.
     *
     * @access	public
     * @return	array
     */
    public function jsonSerialize(): array
    {
        return [
            'type' => '\\'.get_called_class(),
            'modifiers' => $this->toArray(),
        ];
    }
}
