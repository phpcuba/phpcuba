**Description**

Simple function for get public vars of $this or another 
object because `get_object_vars()` have access to private properties

**Example**

```php
class Person {
	public $name = "Peter";
	public $age = 12;
	private $sex = "M";
	protected $secret = "123";

	public function getPublicProperties() {
	  return phpcuba\objects\get_public_vars($this);
	}
}

$person = new Person();
var_dump($person->getPublicProperties());
```