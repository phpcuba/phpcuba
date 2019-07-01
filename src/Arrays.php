<?php

namespace PHPCuba;

class Arrays
{
    /**
     * Complete object/array properties (alias of phpcuba\objects\cop)
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
        return Objects::cop($source, $complement, $level);
    }

    /**
     * Get item from array, checking if exists, returning default
     *
     * @param       $array
     * @param       $index
     * @param mixed $default
     *
     * @return mixed
     * @author @rafageist
     */
    public static function get($array, $index, $default = null)
    {
        if (!is_array($index)) {
            $index = [$index];
        }

        foreach ($index as $v) {
            if (isset($array[$v])) {
                return $array[$v];
            }
        }

        return $default;
    }
}
