<?php

declare(strict_types=1);

namespace VO\BusinessProcess\fields;

use VO\BusinessProcess\fields\traits\FormatTrait;

class DateField extends Field
{
    use FormatTrait;

    protected static string $type = 'date';

    public function __construct(array $properties)
    {
        parent::__construct($properties);
        $this->validateValue();
        $this->format = $properties['format'] ?? null;
    }

    protected function validateValue()
    {
        if (!empty($this->value) && date_create($this->value) === false) {
            throw new \InvalidArgumentException(static::class . ' is given incorrect value "' . $this->value . '"', 5);
        }
    }

    public function getValue(): string
    {
        $value = parent::getValue();

        if (!empty($this->format) && !empty($this->value)) {
            $date = date_create($value);
            $value = date_format($date, $this->format);
        }

        return $value;
    }
}
