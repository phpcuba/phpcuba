<?php

namespace phpcuba\objects;

/**
 * Simple function for get public vars of $this or another object
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
