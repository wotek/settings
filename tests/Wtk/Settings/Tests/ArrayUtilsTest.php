<?php

namespace Wtk\Settings\Tests;

use Wtk\Settings\ArrayUtils;

class ArrayUtilsTest extends \PHPUnit_Framework_TestCase
{
    public function getObject()
    {
        return new ArrayUtils;
    }

    public function getArray()
    {
        return array(
            'flat' => 'bar',
            'foo' => array(
                'bar' => array(
                    'baz' => true,
                    'bat' => false,
                ),
            ),
        );
    }

    public function testFlatNestedArrayToFlatDotNotation()
    {
        $utils = $this->getObject();

        $nested_array = $this->getArray();

        $expected_array = array(
            'flat' => 'bar',
            'foo.bar.baz' => true,
            'foo.bar.bat' => false,
        );

        $this->assertSame(
            $expected_array,
            $utils->dot($nested_array)
        );
    }

    public function testGetNullKey()
    {
        $utils = $this->getObject();

        $array = $this->getArray();

        $this->assertSame(
            $array,
            $utils->get($array, null)
        );
    }

    public function testGetFlatArrayKey()
    {
        $utils = $this->getObject();

        $array = $this->getArray();

        $this->assertSame(
            'bar',
            $utils->get($array, 'flat')
        );
    }

    public function testGetNestedKey()
    {
        $utils = $this->getObject();

        $array = $this->getArray();

        $this->assertSame(
            true,
            $utils->get($array, 'foo.bar.baz')
        );
        $this->assertSame(
            false,
            $utils->get($array, 'foo.bar.bat')
        );
    }

    public function testGetInvalidPathKey()
    {
        $utils = $this->getObject();

        $array = $this->getArray();

        $expected_default_to_be_returned = 'some_default_val';

        $this->assertSame(
            $expected_default_to_be_returned,
            $utils->get(
                $array,
                'foo.bar.not_existing_key',
                $expected_default_to_be_returned
            )
        );
    }

    public function testSetNullKey()
    {
        $utils = $this->getObject();

        $array = $this->getArray();
        $value = 'some_value';

        $this->assertSame(
            $value,
            $utils->set(
                $array,
                null,
                $value
            )
        );
    }

    public function testSetSimpleAndExistingPath()
    {
        $utils = $this->getObject();

        $input_array = array(
            'foo' => array(
                'bar' => 'some_value',
            )
        );

        $output_array = array(
            'foo' => array(
                'bar' => 'new_value',
            )
        );

        $result = $utils->set($input_array, 'foo.bar', 'new_value');

        $this->assertSame(
            $output_array,
            $input_array
        );
        // Set returns just the changed bit:
        $this->assertSame(
            array(
                'bar' => 'new_value',
            ),
            $result
        );
    }

    public function testSetNestedPath()
    {
        $utils = $this->getObject();

        $input_array = array(
            'foo' => array(
                'bar' => 'some_value',
            ),
        );

        $output_array = array(
            'foo' => array(
                'bar' => 'some_value',
                'new' => array(
                    'node' => array(
                        'value' => 'new_value',
                    ),
                ),
            ),
        );

        $result = $utils->set($input_array, 'foo.new.node.value', 'new_value');

        $this->assertSame(
            $output_array,
            $input_array
        );

        // Set returns just the added bit:
        $this->assertSame(
            array(
                'value' => 'new_value',
            ),
            $result
        );
    }
}
