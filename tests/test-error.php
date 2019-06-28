<?php

include "../phpcuba.php";

function get_object_public_vars($object)
{
  return ['Is a joke!'];
}

if (isset($phpcuba_errors)) {
  var_dump($phpcuba_errors);
}
