<?php

namespace PHPCuba;

use Exception;

class Atomic
{
    public static $instance = null;

    private $value = null;
    private $length = 0;

    /**
     * Atomic constructor.
     *
     * @param null $value
     *
     * @throws \Exception
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
     * @throws \Exception
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
        if (!is_scalar($value)) {
            throw new Exception("PHPCuba\Atomic: Value is not scalar");
        }

        $this->value = $value;
        $this->length = strlen("$value");
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
     * @param $other
     *
     * @return bool
     */
    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    /**
     * To string
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->value."";
    }

    /**
     * Alias for __toString
     *
     * @return string
     */
    public function asString(): string
    {
        return $this->__toString();
    }

    /**
     * Apply callable function to value
     *
     * @param $callable
     *
     * @return \PHPCuba\Atomic
     * @throws \Exception
     */
    public function apply($callable)
    {
        if (!is_callable($callable)) {
            throw new Exception('Not callable');
        }

        $this->set($callable($this->get()));

        return $this;
    }

    /**
     * Text length
     *
     * @return int
     */
    public function length(): int
    {
        return $this->length;
    }
}
