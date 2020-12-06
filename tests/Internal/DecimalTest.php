<?php

declare(strict_types=1);

namespace Brick\Validation\Tests\Internal;

use Brick\Validation\Internal\Decimal;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use RangeException;

/**
 * Unit tests for class Decimal.
 */
class DecimalTest extends TestCase
{
    public function testParseWithValueIsOutOfRange() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/Decimal number out of range for this platform: \d+/');

        Decimal::parse('1000000000000000000000000');
    }

    public function testMinusWithSubtractionResultOverflows() : void
    {
        $decimal = Decimal::parse('9223372036854775807');
        $that = Decimal::parse('-92233720368547758');

        $this->expectException(RangeException::class);
        $this->expectExceptionMessage('The subtraction result overflows.');

        $decimal->minus($that);
    }

    public function testScaleValuesWithScaledOverflows() : void
    {
        $decimal = Decimal::parse('100200000300004999.3');
        $that = Decimal::parse('-2.33333');

        $this->expectException(RangeException::class);
        $this->expectExceptionMessage('The scaled result overflows.');

        $decimal->minus($that);
    }
}
