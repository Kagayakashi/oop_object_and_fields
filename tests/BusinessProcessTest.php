<?php

declare(strict_types=1);

namespace VO\BusinessProcess\tests;

use PHPUnit\Framework\TestCase;
use VO\BusinessProcess\BusinessProcess;

final class BusinessProcessTest extends TestCase
{
    public function testExceptionIncorrectFields()
    {
        $fields = ["abc", 1, true, null];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Incorrect fields are given to BusinessProcess');
        $this->expectExceptionCode(1);

        new BusinessProcess($fields);
    }

    public function testExceptionFieldTypeNull()
    {
        $fields = [
            [
                'name' => 'Field name without type'
            ]
        ];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Field type is empty, cannot create Process Field');
        $this->expectExceptionCode(2);

        new BusinessProcess($fields);
    }

    public function testExceptionWrongFieldType()
    {
        $fields = [
            [
                'type' => 'wrong type'
            ]
        ];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Wrong field type is given "wrong type"');
        $this->expectExceptionCode(3);

        new BusinessProcess($fields);
    }

    public function testExceptionFieldAlreadyExist()
    {
        $fields = [
            [
                'name' => 'first field',
                'type' => 'text',
            ],
            [
                'name' => 'first field',
                'type' => 'text',
            ]
        ];

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Field with name "first field" already exist');
        $this->expectExceptionCode(1);

        new BusinessProcess($fields);
    }

    public function testTextField()
    {
        $fields = [
            [
                'name' => 'Text field',
                'type' => 'text',
                'value' => 'This is text field value'
            ],
        ];

        $bp = new BusinessProcess($fields);

        // getFieldsValues
        $fields = $bp->getFieldsValues();

        $this->assertCount(1, $fields);
        $this->assertArrayHasKey('Text field', $fields);
        $this->assertEquals('This is text field value', $fields['Text field']);

        // getFields
        $fields = $bp->getFields();
        $this->assertCount(1, $fields);

        $field = $fields[0];

        $this->assertEquals('Text field', $field->getName());
        $this->assertEquals('This is text field value', $field->getValue());
    }

    public function testNumberFieldNonFormat()
    {
        $fields = [
            [
                'name' => 'Number field',
                'type' => 'number',
                'value' => 123
            ],
        ];

        $bp = new BusinessProcess($fields);

        // getFieldsValues
        $fields = $bp->getFieldsValues();

        $this->assertCount(1, $fields);
        $this->assertArrayHasKey('Number field', $fields);
        $this->assertEquals(123, $fields['Number field']);

        // getFields
        $fields = $bp->getFields();
        $this->assertCount(1, $fields);

        $field = $fields[0];

        $this->assertEquals('Number field', $field->getName());
        $this->assertEquals(123, $field->getValue());
    }

    public function testNumberFieldWithFormat()
    {
        $fields = [
            [
                'name' => 'Format number field',
                'type' => 'number',
                'value' => 123,
                'format' => '%+.2f'
            ],
        ];

        $bp = new BusinessProcess($fields);

        // getFieldsValues
        $fields = $bp->getFieldsValues();

        $this->assertCount(1, $fields);
        $this->assertArrayHasKey('Format number field', $fields);
        $this->assertEquals('+123.00', $fields['Format number field']);

        // getFields
        $fields = $bp->getFields();
        $this->assertCount(1, $fields);

        $field = $fields[0];

        $this->assertEquals('Format number field', $field->getName());
        $this->assertEquals('+123.00', $field->getValue());
    }

    /**
     * Validate date
     *
     * @return void
     */
    public function testIncorrectValueDateField()
    {
        $fields = [
            [
                'name' => 'Date field',
                'type' => 'date',
                'value' => '202-30-107'
            ],
        ];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('VO\BusinessProcess\fields\DateField is given incorrect value "202-30-107"');
        $this->expectExceptionCode(5);

        new BusinessProcess($fields);
    }

    public function testDateFieldNonFormat()
    {
        $fields = [
            [
                'name' => 'Date field',
                'type' => 'date',
                'value' => '2023-01-07'
            ],
        ];

        $bp = new BusinessProcess($fields);

        // getFieldsValues
        $fields = $bp->getFieldsValues();

        $this->assertCount(1, $fields);
        $this->assertArrayHasKey('Date field', $fields);
        $this->assertEquals('2023-01-07', $fields['Date field']);

        // getFields
        $fields = $bp->getFields();
        $this->assertCount(1, $fields);

        $field = $fields[0];

        $this->assertEquals('Date field', $field->getName());
        $this->assertEquals('2023-01-07', $field->getValue());
    }

    public function testDateFieldWithFormat()
    {
        $fields = [
            [
                'name' => 'Format date field',
                'type' => 'date',
                'value' => '2023-01-07',
                'format' => 'd.m.Y'
            ],
        ];

        $bp = new BusinessProcess($fields);

        // getFieldsValues
        $fields = $bp->getFieldsValues();

        $this->assertCount(1, $fields);
        $this->assertArrayHasKey('Format date field', $fields);
        $this->assertEquals('07.01.2023', $fields['Format date field']);

        // getFields
        $fields = $bp->getFields();
        $this->assertCount(1, $fields);

        $field = $fields[0];

        $this->assertEquals('Format date field', $field->getName());
        $this->assertEquals('07.01.2023', $field->getValue());
    }

    public function testAddField()
    {
        $bp = new BusinessProcess([]);

        // Empty field list
        $fields = $bp->getFields();
        $this->assertCount(0, $fields);

        $newField = [
            'name' => 'Text field',
            'type' => 'text',
            'value' => 'This is text field value'
        ];

        // Add new field
        $bp->addFieldFromArray($newField);

        // getFieldsValues
        $fields = $bp->getFieldsValues();

        $this->assertCount(1, $fields);
        $this->assertArrayHasKey('Text field', $fields);
        $this->assertEquals('This is text field value', $fields['Text field']);

        // getFields
        $fields = $bp->getFields();
        $this->assertCount(1, $fields);

        $field = $fields[0];

        $this->assertEquals('Text field', $field->getName());
        $this->assertEquals('This is text field value', $field->getValue());
    }
}
