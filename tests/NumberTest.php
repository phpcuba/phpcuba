<?php

namespace PHPCuba\Tests;

use PHPCuba\Number;
use PHPUnit\Framework\TestCase;

/**
 * Class ObjectsTest
 *
 * @package PHPCuba\Tests
 */
class NumberTest extends TestCase
{

    /**
     * @throws \Exception
     */
    public function testGetIntegerDigit(){
        $number = new Number(2567);
        $digit = $number->getDigitOfIntPart(3);
        $this->assertEquals($digit, 5);
    }
}
