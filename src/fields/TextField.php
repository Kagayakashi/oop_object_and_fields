<?php

declare(strict_types=1);

namespace VO\BusinessProcess\fields;

class TextField extends Field
{
    protected static string $type = 'text';

    public function __construct(array $properties)
    {
        parent::__construct($properties);
    }
}
