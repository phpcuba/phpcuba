<?php
declare(strict_types=1);

namespace PHPCuba;

use Exception;
use DateTime;

/**
 * Para asegurar values de un tipo específico
 *
 * @author @liancastellon
 */
class Type
{
    /**
     * Check
     *
     * @param mixed  $value
     * @param        $checker
     * @param string $message
     *
     * @return mixed
     * @throws \Exception
     */
    private static function forceTo($value, $checker, string $message)
    {
        if (is_null($value)) {
            throw new Exception("Value is null");
        }

        if (is_callable($checker)) {
            if (!$checker($value)) {
                throw new Exception($message);
            }
        } else {
            if (is_string($checker)) {
                if (method_exists(self::class, $checker)) {
                    if (!self::$checker($value)) {
                        throw new Exception($message);
                    }
                }
            }

            if (!$checker) {
                throw new Exception($message);
            }
        }

        return $value;
    }

    /**
     * Check for positive integer
     *
     * @param $value
     *
     * @return bool
     */
    public static function isPositiveInteger($value)
    {
        return is_int($value) && $value > 0;
    }

    /**
     * Force positive integer
     *
     * @param $value
     *
     * @return int
     * @throws \Exception
     */
    public static function forcePositiveInteger(int $value): int
    {
        return self::forceTo($value, 'isPositiveInteger', 'Value is not positive integer');
    }

    /**
     * Force date time
     *
     * @param \DateTime $value
     *
     * @return object
     * @throws \Exception
     */
    public static function forceDateTime(DateTime $value)
    {
        return self::forceInstanceOf($value, 'DateTime');
    }

    /**
     * Force resource
     *
     * @param $value
     *
     * @return resource
     * @throws \Exception
     */
    public static function forceResource($value)
    {
        return self::forceTo($value, 'is_resource', 'Value is a resource');
    }

    /**
     * Force object and instance of class
     *
     * @param mixed       $value
     *
     * @param string|null $class
     *
     * @return object
     * @throws \Exception
     */
    public static function forceInstanceOf($value, string $class)
    {
        return self::forceTo($value, $value instanceof $class, "Value is not an object or instance of $class");
    }

    /**
     * Check if is array of arrays
     *
     * @param $value
     *
     * @return bool
     */
    public static function isArrayOfArrays($value): bool
    {
        if (!is_array($value)) {
            return false;
        }
        foreach ($value as $item) {
            if (!is_array($item)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Force array of arrays
     *
     * @param array $value
     *
     * @return array
     * @throws \Exception
     */
    public static function forceArrayOfArrays(array $value)
    {
        return self::forceTo($value, 'isArrayOfArrays', 'Value is not an array of arrays');
    }

    /**
     * Check for array of strings
     *
     * @param array $value
     *
     * @return bool
     */
    public static function isArrayOfStrings(array $value): bool
    {
        foreach ($value as $item) {
            if (! is_string($item)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array $value
     *
     * @return array
     * @throws \Exception
     */
    public static function forceArrayOfStrings(array $value)
    {
        return self::forceTo($value, 'isArrayOfStrings', 'Value is not an array of strings');
    }

    /**
     * Check for array of integers
     *
     * @param array $value
     *
     * @return bool
     */
    public static function isArrayOfInt(array $value): bool
    {
        foreach ($value as $item) {
            if (!is_int($item)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Force to array of integers
     *
     * @param array $value
     *
     * @return array
     * @throws \Exception
     */
    public static function forceArrayOfInt(array $value)
    {
        return self::forceTo($value, 'isArrayOfInt', 'Value is not an array of integers');
    }

    /**
     * Check for array of objects
     *
     * @param array $value
     *
     * @return bool
     */
    public static function isArrayOfObjects(array $value): bool
    {
        foreach ($value as $item) {
            if (!is_object($item)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check for array of instances
     *
     * @param array  $value
     * @param string $class
     *
     * @return bool
     */
    public static function isArrayOfInstances(array $value, string $class): bool
    {
        foreach ($value as $item) {
            if (!($item instanceof $class)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Force to array of objects
     *
     * @param array $value
     *
     * @return array
     * @throws \Exception
     */
    public static function forceArrayOfObjects(array $value)
    {
        return self::forceTo($value, 'isArrayOfObjects', 'Value is not array of objects');
    }

    /**
     * Force to array of instances
     *
     * @param array  $value
     * @param string $class
     *
     * @return array
     * @throws \Exception
     */
    public static function forceArrayOfInstances(array $value, string $class)
    {
        return self::forceTo($value, function (array $list) use ($class) {
            return self::isArrayOfInstances($list, $class);
        }, 'Value is not array of instances');
    }

    /**
     * Check if is associative array (map)
     *
     * @param array $value
     *
     * @return bool
     */
    public static function isMap(array $value): bool
    {
        foreach ($value as $key => $item) {
            if (!is_string($key)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Force to associative array (map)
     *
     * @param array $value
     *
     * @return array
     * @throws \Exception
     */
    public static function forceToMap(array $value): array
    {
        return self::forceTo($value, 'isMap', 'Value is not an associative array or map');
    }

    /**
     * Check for string map
     *
     * @param array $value
     *
     * @return bool
     */
    public function isMapOfStrings(array $value): bool
    {
        foreach ($value as $key => $item) {
            if (!is_string($key) || !is_string($item)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Force to string map
     *
     * @param array $value
     *
     * @return array
     * @throws \Exception
     */
    public static function forceToMapOfStrings(array $value): array
    {
        return self::forceTo($value, 'isMapOfStrings', 'Value is not an map of strings');
    }

    /**
     * Check for map of string arrays
     *
     * @param array $value
     *
     * @return bool
     */
    public static function isMapOfStringArrays(array $value): bool
    {
        foreach ($value as $key => $item) {
            if (!is_string($key)) {
                return false;
            }
            if (!self::isArrayOfStrings($item)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Force to map of string arrays
     *
     * @param array $value
     *
     * @return array
     * @throws \Exception
     */
    public static function forceMapOfStringArrays(array $value)
    {
        return self::forceTo($value, 'isMapOfStringArrays', 'Value is not a map of string arrays');
    }
}
