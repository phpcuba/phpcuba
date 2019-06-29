<?php

namespace phpcuba\objects;

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
 *     return phpcuba\objects\get_public_vars($this);
 *   }
 * }
 *
 * $person = new Person();
 * var_dump($person->getPublicProperties());
 *
 * @param $object
 *
 * @return array
 * @author @rafageist
 *
 */

function get_public_vars($object)
{
  return get_object_vars($object);
}
