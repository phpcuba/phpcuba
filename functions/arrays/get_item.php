<?php

namespace phpcuba\arrays;

/**
 * Get item from array, checking if exists, returning default
 *
 * @param       $array
 * @param       $index
 * @param mixed $default
 *
 * @return mixed
 */
function get_item($array, $index, $default = null)
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