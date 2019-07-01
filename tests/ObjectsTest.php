<?php

namespace PHPCuba\Tests;

use PHPCuba\Objects;
use PHPUnit\Framework\TestCase;

class ObjectsTest extends TestCase
{
    public function providerNonObjectValues()
    {
        return [
            [mt_rand(1, 10)],           // random integer
            [boolval(mt_rand(0, 1))],   // random boolean
            [uniqid()],                 // random string
            [range(1, mt_rand(1, 10))], // random array
        ];
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Value of $object argument is not an object.
     * @dataProvider providerNonObjectValues
     */
    public function testGetAttributeThrownsAnExceptionWhenObjectArgumentIsNotAnObject($value)
    {
        Objects::getAttribute($value, 'attributeName');
    }

    public function testGetAttributeReturnsPublicValues()
    {
        $obj = new class {
            public $attribute = 'secret';
        };

        $this->assertEquals('secret', Objects::getAttribute($obj, 'attribute'));
    }

    public function testGetAttributeReturnsPrivateValues()
    {
        $obj = new class {
            private $attribute = 'secret';
        };

        $this->assertEquals('secret', Objects::getAttribute($obj, 'attribute'));
    }

    public function testGetAttributeReturnsProtectedValues()
    {
        $obj = new class {
            protected $attribute = 'secret';
        };

        $this->assertEquals('secret', Objects::getAttribute($obj, 'attribute'));
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Value of $object argument is not an object.
     * @dataProvider providerNonObjectValues
     */
    public function testSetAttributeThrownsAnExceptionWhenObjectArgumentIsNotAnObject($value)
    {
        Objects::setAttribute($value, 'attributeName', $value);
    }

    public function testSetAttributeWithAPublicAttribute()
    {
        $value = uniqid();
        $obj = new class {
            public $attribute;
        };

        Objects::setAttribute($obj, 'attribute', $value);

        $this->assertAttributeEquals($value, 'attribute', $obj);
    }

    public function testSetAttributeWithAPrivateAttribute()
    {
        $value = uniqid();
        $obj = new class {
            private $attribute;
        };

        Objects::setAttribute($obj, 'attribute', $value);

        $this->assertAttributeEquals($value, 'attribute', $obj);
    }

    public function testSetAttributeWithAProtectedAttribute()
    {
        $value = uniqid();
        $obj = new class {
            protected $attribute;
        };

        Objects::setAttribute($obj, 'attribute', $value);

        $this->assertAttributeEquals($value, 'attribute', $obj);
    }
}
