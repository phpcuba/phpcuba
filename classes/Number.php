<?php

namespace PHPCuba;

class Number extends Atomic {

  /**
   * Sum
   *
   * @param $value
   *
   * @return \PHPCuba\Number
   */
  public function sum($value): self {
    if (!is_numeric($value))
    {
      throw new Exception("PHPCuba\Number $value is not numeric");
    }

    $this->set($this->get() + $value * 1);

    return $this;
  }

}