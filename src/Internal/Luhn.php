<?php

namespace Brick\Validation\Internal;

/**
 * Luhn algorithm calculations.
 *
 * @internal
 */
class Luhn
{
    /**
     * Computes and returns the check digit of a number.
     *
     * @param string $number
     *
     * @return int
     *
     * @throws \InvalidArgumentException
     */
    public static function getCheckDigit(string $number) : int
    {
        if (! ctype_digit($number)) {
            throw new \InvalidArgumentException('The number must be a string of digits');
        }

        $checksum = self::checksum($number . '0');

        return ($checksum === 0) ? 0 : 10 - $checksum;
    }

    /**
     * Checks that a number is valid.
     *
     * @param string $number
     *
     * @return bool
     */
    public static function isValid(string $number) : bool
    {
        if (ctype_digit($number)) {
            return self::checksum($number) === 0;
        }

        return false;
    }

    /**
     * Computes the checksum of a number.
     *
     * @param string $number The number, validated as a string of digits.
     *
     * @return int
     */
    private static function checksum(string $number) : int
    {
        $number = strrev($number);
        $length = strlen($number);

        $sum = 0;

        for ($i = 0; $i < $length; $i++) {
            $value = $number[$i] * ($i % 2 + 1);
            $sum += ($value >= 10 ? $value - 9 : $value);
        }

        return $sum % 10;
    }
}
