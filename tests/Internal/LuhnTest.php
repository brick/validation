<?php

declare(strict_types=1);

namespace Brick\Validation\Tests\Internal;

use Brick\Validation\Internal\Luhn;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for class Luhn.
 */
class LuhnTest extends TestCase
{
    /**
     * @dataProvider luhnProvider
     *
     * @param string $number
     */
    public function testLuhn(string $number) : void
    {
        $rawNumber = substr($number, 0, -1);
        $checkDigit = (int) $number[-1];

        // Ensure that the check digit is correctly computed.
        $this->assertSame($checkDigit, Luhn::getCheckDigit($rawNumber));

        // Ensure that the number is valid only with the correct check digit.
        for ($digit = 0; $digit < 10; $digit++) {
            $this->assertEquals($digit == $checkDigit, Luhn::isValid($rawNumber . $digit));
        }
    }

    public function testGetCheckDigitWithInvalidDigitNumber() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The number must be a string of digits');

        Luhn::getCheckDigit('invalid_digit_number');
    }

    /*
     * @return array
     */
    public function luhnProvider() : array
    {
        return [
            // Wikipedia example
            ['79927398713'],

            // SIM card numbers
            ['8944122650378240218'],
            ['89441000301666324720'],

            // IMEI
            ['448674528976410'],
            ['869222002618577'],
            ['010928003890233'],

            // Random VISA numbers
            ['4776655332450506'],
            ['4211133709046888'],
            ['4176419122347364'],
            ['4526109963236019'],
            ['4879788010058840'],

            // Random Mastercard numbers
            ['5529865806184716'],
            ['5172728358275292'],
            ['5270443449064934'],
            ['5135847995967529'],
            ['5114528561886815'],

            // Random American Express numbers
            ['362675992823493'],
            ['340288889835203'],
            ['369136545167220'],
            ['343062927266144'],
            ['365931167626865'],

            // Random Discover numbers
            ['6011423258413838'],
            ['6011130582176425'],
            ['6011035275583565'],
            ['6011444679519276'],
            ['6011639554808609']
        ];
    }
}
