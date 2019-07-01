<?php

namespace PHPCuba\Tests;

/**
 * Class TestClass
 * Serialization of 'class@anonymous' is not allowed
 *
 * @package PHPCuba\Tests
 */
class TestClass
{

    protected $attrProtected;

    private $attrPrivate;

    public $attrPublic;

    /**
     * Get
     *
     * @return mixed
     */
    public function getAttrPrivate()
    {
        return $this->attrPrivate;
    }

    /**
     * Set
     *
     * @param mixed $attrPrivate
     */
    public function setAttrPrivate($attrPrivate)
    {
        $this->attrPrivate = $attrPrivate;
    }

    /**
     * @return mixed
     */
    public function getAttrProtected()
    {
        return $this->attrProtected;
    }

    /**
     * @param mixed $attrProtected
     */
    public function setAttrProtected($attrProtected)
    {
        $this->attrProtected = $attrProtected;
    }
}
