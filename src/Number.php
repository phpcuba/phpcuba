<?php

namespace PHPCuba;

use RuntimeException;

class Number extends Atomic
{

    /**
     * Number constructor.
     *
     * @param  mixed  $value
     *
     * @throws \Exception
     */
    public function __construct($value = null){

        if (!is_numeric($value)) {
            throw new RuntimeException("PHPCuba\Number $value is not numeric");
        }

        $value *= 1;

        parent::__construct($value);
    }

    /**
     * Sum
     *
     * @param $value
     *
     * @return \PHPCuba\Number
     * @throws \Exception
     */
    public function sum($value): self
    {
        if (!is_numeric($value)) {
            throw new RuntimeException("PHPCuba\Number $value is not numeric");
        }

        $this->set($this->get() + $value * 1);

        return $this;
    }

    /**
     * Is integer ?
     */
    public function isInteger() {
        return is_int($this->get());
    }

    /**
     * Get integer part
     *
     * @return int
     */
    public function toInt(): int{
        return (int) $this->get();
    }

    /**
     * Get a digit of the integer part
     *
     * @param integer $pos
     *
     * @return int
     */
    public function getDigitOfIntPart(int $pos): int {
        return self::getDigitOfInt($this->toInt(), $pos);
    }

    /**
     * Get a digit of integer number
     *
     * @param int $number
     * @param int $pos
     *
     * @return int
     */
    public static function getDigitOfInt(int $number, int $pos): int
    {
        // example
        $integer = (int) $number;
        $digit = null;

        for ($i = 1; $i <= $pos; $i++)
        {
            // drop last digit
            $dropped = (int) ($integer / 10);

            // get last digit
            $digit = $integer - $dropped * 10;

            // update current number
            $integer  = $dropped;
        }

        return $digit;
    }
}
