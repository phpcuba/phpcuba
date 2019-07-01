<?php

namespace PHPCuba;

class Objects
{
    /**
     *
     * Simple function for get public vars of $this or another
     * object because `get_object_vars()` have access to private properties

     * @example
     * ```php
     *   use PHPCuba;
     *
     *   class Person {
     *     public $name = "Peter";
     *     public $age = 12;
     *     private $sex = "M";
     *     protected $secret = "123";
     *
     *     public function getPublicProperties() {
     *      return ObjectHelper::getPublicVars($this);
     *     }
     *   }
     *
     *   $person = new Person();
     *   var_dump($person->getPublicProperties());
     *
     * @param $object
     *
     * @return array
     * @author @rafageist
     */
    public static function getPublicVars($object)
    {
        return get_object_vars($object);
    }

    /**
     * (C)omplete (O)bject/array (P)roperties
     *
     * @param mixed   $source
     * @param mixed   $complement
     * @param integer $level
     *
     * @return mixed
     * @author @rafageist
     */
    public static function cop(&$source, $complement, $level = 0)
    {
        $null = null;

        if (is_null($source)) {
            return $complement;
        }

        if (is_null($complement)) {
            return $source;
        }

        if (is_scalar($source) && is_scalar($complement)) {
            return $complement;
        }

        if (is_scalar($complement) || is_scalar($source)) {
            return $source;
        }

        if ($level < 100) { // prevent infinite loop
            if (is_object($complement)) {
                $complement = get_object_vars($complement);
            }

            foreach ($complement as $key => $value) {
                if (is_object($source)) {
                    if (property_exists($source, $key)) {
                        $source->$key = self::cop($source->$key, $value, $level + 1);
                    } else {
                        $source->$key = self::cop($null, $value, $level + 1);
                    }
                }
                if (is_array($source)) {
                    if (key_exists($key, $source)) {
                        $source [$key] = self::cop($source[$key], $value, $level + 1);
                    } else {
                        $source[$key] = self::cop($null, $value, $level + 1);
                    }
                }
            }
        }

        return $source;
    }

    /**
     * Cast object to class
     *
     * @param $instance
     * @param $class
     * @author @rafageist
     *
     * @return mixed
     */
    public static function cast($instance, $class)
    {
        return unserialize(sprintf(
            'O:%d:"%s"%s',
            strlen($class),
            $class,
            strstr(strstr(serialize($instance), '"'), ':')
        ));
    }

    /**
     * Returns the value of an attribute regardless of the type of visibility it has.
     *
     * @author @andaniel05
     *
     * @throws \Exception
     *
     * @param  object $object
     * @param  string $attribute
     *
     * @return mixed
     */
    public static function getAttribute($object, string $attribute)
    {
        if (! is_object($object)) {
            throw new \Exception('Value of $object argument is not an object.');
        }

        $value = (function (string $attribute) {
            return $this->{$attribute};
        })->call($object, $attribute);

        return $value;
    }

    /**
     * Sets an value to an attribute regardless of the type of visibility it has.
     *
     * @author @andaniel05
     *
     * @throws \Exception
     *
     * @param  object $object
     * @param  string $attribute
     * @param  mixed $value
     */
    public static function setAttribute($object, string $attribute, $value): void
    {
        if (! is_object($object)) {
            throw new \Exception('Value of $object argument is not an object.');
        }

        (function (string $attribute, $value) {
            $this->{$attribute} = $value;
        })->call($object, $attribute, $value);
    }
}
