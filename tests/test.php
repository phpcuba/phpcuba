<?php

include "../phpcuba.php";

class Person
{

  // publics
  public $name = "Peter";

  public $age = 12;

  // non-publics
  private $sex = "M";

  protected $secret = "123";

  /**
   * This method return the list of public properties
   *
   * @return array
   */
  public function getPublicProperties()
  {
    return phpcuba\get_object_public_vars($this);
  }

  /**
   * Test
   */
  public function test()
  {
    // show all properties
    var_dump(get_object_vars($this));

    // show only all properties
    var_dump(phpcuba\get_object_public_vars($this));
  }
}

$person = new Person();
$person->test();
