<?php

declare(strict_types=1);

namespace VO\BusinessProcess;

use VO\BusinessProcess\fields\Field;
use VO\BusinessProcess\fields\TextField;
use VO\BusinessProcess\fields\NumberField;
use VO\BusinessProcess\fields\DateField;

class BusinessProcess
{
    /**
     * @var Field[]
     */
    protected array $fields = [];

    public function __construct(array $fields)
    {
        foreach ($fields as $field) {
            if (!is_array($field)) {
                throw new \InvalidArgumentException("Incorrect fields are given to BusinessProcess", 1);
            }

            $processField = $this->fieldFabric($field);
            $this->addField($processField);
        }
    }

    public function getFieldsValues(): array
    {
        $fields = [];
        foreach ($this->fields as $name => $field) {
            $fields[$name] = $field->getValue();
        }

        return $fields;
    }

    /**
     * @return Field[]
     */
    public function getFields(): array
    {
        $fields = [];
        foreach ($this->fields as $name => $field) {
            $fields[] = $field;
        }

        return $fields;
    }

    public function addFieldFromArray(array $field)
    {
        if (!is_array($field)) {
            throw new \InvalidArgumentException("Incorrect fields are given to BusinessProcess", 1);
        }

        $processField = $this->fieldFabric($field);
        $this->addField($processField);
    }

    public function addField(Field $field)
    {
        // Check fields for unique name
        $name = $field->getName();
        if (!empty($this->fields[$name])) {
            throw new \LogicException('Field with name "' . $name . '" already exist', 1);
        }

        $this->fields[$name] = $field;
    }

    public function fieldFabric(array $props): Field
    {
        if (empty($props['type'])) {
            throw new \InvalidArgumentException("Field type is empty, cannot create Process Field", 2);
        }

        switch ($props['type']) {
            case 'text':
                $field = new TextField($props);
                break;
            case 'number':
                $field = new NumberField($props);
                break;
            case 'date':
                $field = new DateField($props);
                break;
            default:
                $field = null;
                break;
        }

        if (empty($field)) {
            throw new \InvalidArgumentException('Wrong field type is given "' . $props['type'] . '"', 3);
        }

        return $field;
    }
}
