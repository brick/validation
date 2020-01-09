<?php

declare(strict_types=1);

namespace Brick\Validation\Tests\Internal;

use Brick\Validation\Internal\Decimal;

use PHPUnit\Framework\TestCase;

/**
 * Unit tests for class Decimal.
 */
class DecimalTest extends TestCase
{
    /**
     * @expectedException              \InvalidArgumentException
     * @expectedExceptionMessageRegExp /Decimal number out of range for this platform: \d+/
     */
    public function testParseWithValueIsOutOfRange() : void
    {
        Decimal::parse('1000000000000000000000000');
    }

    /**
     * @expectedException        \RangeException
     * @expectedExceptionMessage The subtraction result overflows.
     */
    public function testMinusWithSubtractionResultOverflows() : void
    {
        $decimal = Decimal::parse('9223372036854775807');
        $that = Decimal::parse('-92233720368547758');
        $decimal->minus($that);
    }

    /**
     * @expectedException        \RangeException
     * @expectedExceptionMessage The scaled result overflows.
     */
    public function testScaleValuesWithScaledOverflows() : void
    {
        $decimal = Decimal::parse('100200000300004999.3');
        $that = Decimal::parse('-2.33333');
        $decimal->minus($that);
    }
}
