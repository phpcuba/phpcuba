<?php

include "../phpcuba.php";

use function phpcuba\objects\get_public_vars;

class Person
{

  // publics
  public $name = "Peter";

  public $age = 12;

  // non-publics
  private $sex = "M";

  protected $secret = "123";

  /**
   * Test
   */
  public function test()
  {
    // show all properties
    var_dump(get_object_vars($this));

    // show only all properties
    var_dump(get_public_vars($this));
  }
}

$person = new Person();
$person->test();
