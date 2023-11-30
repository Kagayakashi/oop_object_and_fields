<?php

declare(strict_types=1);

namespace VO\BusinessProcess\fields;

abstract class Field
{
    protected static string $type;
    protected string $name;
    protected mixed $value;

    public function __construct(array $properties)
    {
        if (!isset(static::$type)) {
            throw new \Exception(static::class . "field type is null", 1);
        }

        if (empty($properties['name'])) {
            throw new \InvalidArgumentException(static::class . " property name is null", 4);
        }

        $this->name = $properties['name'];
        $this->value = $properties['value'] ?? null;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public static function getType(): string|null
    {
        return static::$type;
    }
}
