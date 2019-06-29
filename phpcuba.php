<?php

namespace phpcuba;

/**
 * Cuban PHP Community
 *
 * More functions for PHP. Strengthen PHP with new functions.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License
 * for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program as the file LICENSE.txt; if not, please see
 *
 * https://www.gnu.org/licenses/gpl-3.0.txt
 *
 * @see https://t.me/phpcuba
 * @see https://phpcuba.org
 */

!defined('PHPCUBA_ERRORS_DEPOSIT') and define('PHPCUBA_ERRORS_DEPOSIT', 'phpcuba_errors');

/**
 * Record errors in global var
 *
 * @param $message
 */
function phpcuba_error($message)
{

  if (!isset($GLOBALS[PHPCUBA_ERRORS_DEPOSIT])) {
    $GLOBALS[PHPCUBA_ERRORS_DEPOSIT] = [];
  }

  $GLOBALS[PHPCUBA_ERRORS_DEPOSIT][] = [
    "timestamp" => date("Y-m-d h:i:s"),
    "message"   => $message,
  ];
}

// --------------------------------- OBJECT AND CLASSES ---------------------------- //
/**
 * Simple function for get public vars of $this
 *
 * class Person {
 *   public $name = "Peter";
 *   public $age = 12;
 *   private $sex = "M";
 *   protected $secret = "123";
 *
 *   public function getPublicProperties() {
 *     return get_object_public_vars($this);
 *   }
 * }
 *
 * $person = new Person();
 * var_dump($person->getPublicProperties());
 *
 * @param $object
 *
 * @return array
 * @author @phpcuba
 *
 */

if (function_exists('get_object_public_vars')) {
  phpcuba_error("LOADING: Function get_object_public_vars() already exists");
  goto more0001;
}

function get_object_public_vars($object)
{
  return get_object_vars($object);
}

more0001:

/**
 * Complete object/array properties
 *
 * @param mixed   $source
 * @param mixed   $complement
 * @param integer $level
 *
 * @return mixed
 */
if (function_exists('cop')) {
  phpcuba_error("LOADING: Function cop() already exists");
  goto more0002;
}

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

// ------------------------------------- STRINGS ----------------------------- //
more0002:

/**
 * Clear string
 *
 * @param String $name
 * @param String $chars
 * @param bool $direction True for keep, false for delete
 *
 * @return String
 */
function str_clear($name, $chars, $direction = true)
{
  $l = strlen($name);
  $new_name = '';
  $chars .= $extra_chars;

  for($i = 0; $i < $l; $i ++)
  {
    $ch = $name[$i];
    if(stripos($chars, $ch) === $direction)
    {
      $new_name .= $ch;
    }
  }

  return $new_name;
}


// EOF
