<?php

include "classes/Type.php";
use PHPCuba\Type;

try {
  $value = ['a', 'b'];
  $r = Type::forceArrayOfStrings($value);
  var_dump($r);
  var_dump(Type::isArrayOfStrings($value));
}
catch (Exception $e) {
  echo $e->getMessage();
}
