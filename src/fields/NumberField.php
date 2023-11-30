<?php

declare(strict_types=1);

namespace VO\BusinessProcess\fields;

use VO\BusinessProcess\fields\traits\FormatTrait;

class NumberField extends Field
{
    use FormatTrait;

    protected static string $type = 'number';

    public function __construct(array $properties)
    {
        parent::__construct($properties);

        $this->format = $properties['format'] ?? null;
    }

    public function getValue(): string|int
    {
        $value = (int) parent::getValue();

        if (!empty($this->format) && !empty($this->value)) {
            $value = sprintf($this->format, $value);
        }

        return $value;
    }
}
