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

// EOF
