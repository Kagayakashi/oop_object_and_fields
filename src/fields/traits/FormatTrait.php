<?php

declare(strict_types=1);

namespace VO\BusinessProcess\fields\traits;

/**
 * Trait adds format methods for values.
 * 
 * Afte use, redeclade Field::getValue() method.
 */
trait FormatTrait
{
    protected string|null $format;

    public function getFormat(): string|null
    {
        return $this->format;
    }
}

