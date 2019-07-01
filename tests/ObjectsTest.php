<?php

namespace PHPCuba\Tests;

use PHPCuba\Objects;
use PHPUnit\Framework\TestCase;

/**
 * Class ObjectsTest
 *
 * @package PHPCuba\Tests
 */
class ObjectsTest extends TestCase
{

    /**
     * Provider Non Object Values
     *
     * @return array
     * @throws \Exception
     */
    public function providerNonObjectValues(): array
    {
        return [
            [random_int(1, 10)],           // random integer
            [(bool)random_int(0, 1)],   // random boolean
            [uniqid('', true)],                 // random string
            [range(1, random_int(1, 10))], // random array
        ];
    }

    /**
     * testGetAttributeThrownsAnExceptionWhenObjectArgumentIsNotAnObject
     *
     * @expectedException \Exception
     * @expectedExceptionMessage Value of $object argument is not an object.
     * @dataProvider             providerNonObjectValues
     *
     * @param $value
     *
     * @throws \Exception
     */
    public function testGetAttributeThrownsAnExceptionWhenObjectArgumentIsNotAnObject($value)
    {
        Objects::getAttribute($value, 'attributeName');
    }

    /**
     * Test get public attributes
     *
     * @throws \Exception
     */
    public function testGetAttributeReturnsPublicValues()
    {
        $obj = new TestClass();
        $obj->attrPublic = 'secret';
        $this->assertEquals('secret', Objects::getAttribute($obj, 'attrPublic'));
    }

    /**
     * Test get private values
     *
     * @throws \Exception
     */
    public function testGetAttributeReturnsPrivateValues()
    {
        $obj = new TestClass();
        $obj->setAttrPrivate('secret');
        $this->assertEquals('secret', Objects::getAttribute($obj, 'attrPrivate'));
    }

    /**
     * Test get protected values
     *
     * @throws \Exception
     */
    public function testGetAttributeReturnsProtectedValues()
    {
        $obj = new TestClass();
        $obj->setAttrProtected('secret');
        $this->assertEquals('secret', Objects::getAttribute($obj, 'attrProtected'));
    }

    /**
     * Test set attribute
     *
     * @param mixed $value
     *
     * @expectedException \Exception
     * @expectedExceptionMessage Value of $object argument is not an object.
     * @dataProvider             providerNonObjectValues
     */
    public function testSetAttributeThrownsAnExceptionWhenObjectArgumentIsNotAnObject($value)
    {
        Objects::setAttribute($value, 'attributeName', $value);
    }

    /**
     * testSetAttributeWithAPublicAttribute
     *
     * @throws \Exception
     */
    public function testSetAttributeWithAPublicAttribute()
    {
        $this->commonTestSetAttribute('attrPublic');
    }

    /**
     * testSetAttributeWithAPrivateAttribute
     *
     * @throws \Exception
     */
    public function testSetAttributeWithAPrivateAttribute()
    {
        $this->commonTestSetAttribute('attrPrivate');
    }

    /**
     * testSetAttributeWithAProtectedAttribute
     *
     * @throws \Exception
     */
    public function testSetAttributeWithAProtectedAttribute()
    {
        $this->commonTestSetAttribute('attrProtected');
    }

    /**
     * Common test
     *
     * @param $attr
     *
     * @throws \Exception
     */
    private function commonTestSetAttribute($attr)
    {
        $value = uniqid('', true);
        $obj = new TestClass();
        Objects::setAttribute($obj, $attr, $value);
        // $this->assertContains('"'.$value.'"', serialize($obj));
        $this->assertEquals($value, Objects::getAttribute($obj, $attr));
    }
}
