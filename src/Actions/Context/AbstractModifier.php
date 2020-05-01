<?php

namespace PhpMetric\Actions\Context;

abstract class AbstractModifier implements ModifierInterface
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    abstract public function apply($context);

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
            'data' => $this->data,
        ];
    }
}
