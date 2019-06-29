<?php

namespace phpcuba\objects;

/**
 * Complete object/array properties
 *
 * @param mixed   $source
 * @param mixed   $complement
 * @param integer $level
 *
 * @author @rafageist
 *
 * @return mixed
 */

function cop(&$source, $complement, $level = 0)
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
          $source->$key = cop($source->$key, $value, $level + 1);
        }
        else {
          $source->$key = cop($null, $value, $level + 1);
        }
      }
      if (is_array($source)) {
        if (key_exists($key, $source)) {
          $source [$key] = cop($source[$key], $value, $level + 1);
        }
        else {
          $source[$key] = cop($null, $value, $level + 1);
        }
      }
    }
  }

  return $source;
}