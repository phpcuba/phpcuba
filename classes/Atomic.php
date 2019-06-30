<?php

namespace PHPCuba;

class Atomic
{

  static $instance = null;

  private $value = null;

  /**
   * Atomic constructor.
   *
   * @param null $value
   */
  public function __construct($value = null)
  {
    $this->set($value);
  }

  /**
   * Factory
   *
   * @param null $value
   *
   * @return self
   */
  public static function getInstance($value = null): self
  {
    return new self($value);
  }

  /**
   * Setter
   *
   * @throws Exception
   * @param $value
   */
  public function set($value)
  {
    if (!is_scalar($value))
    {
      throw new Exception("PHPCuba\Atomic: Value is not scalar");
    }

    $this->value = $value;
  }

  /**
   * Getter
   *
   *
   * @return mixed
   */
  public function get()
  {
    return $this->value;
  }

  /**
   * Reference
   *
   * @return mixed
   */
  public function &reference()
  {
    return $this->value;
  }

  /**
   * Compare equals
   *
   * @param Text $other
   *
   * @return bool
   */
  public function equals(self $other): bool
  {
    return $this->value === $other->value;
  }
}