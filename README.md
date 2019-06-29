# More functions for PHP

Strengthen PHP with new functions.

## Installation

```
composer require phpcuba\phpcuba;
```

## Usage
```php

use PHPCuba;

$result = PHPCuba\{some class here}::{some function here}(...);
```

## Example

Simple function for get public vars of $this or another 
object because `get_object_vars()` have access to private properties

**Example**

```php

use phpcuba;

class Person {
  public $name = "Peter";
  public $age = 12;
  private $sex = "M";
  protected $secret = "123";

  public function getPublicProperties() {
  	
  	var_dump(get_object_vars($this);
  	
    return ObjectHelper::getPublicVars($this);
  }
}

$person = new Person();
var_dump($person->getPublicProperties());
```

## Authors

Cuban PHP Community [https://phpcuba.org]

Enjoy!