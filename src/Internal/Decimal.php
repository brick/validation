<?php

namespace Brick\Validation\Internal;

/**
 * Simple int-based decimal class.
 *
 * @internal
 */
class Decimal
{
    /**
     * @var int
     */
    private $value;

    /**
     * @var int
     */
    private $scale;

    /**
     * Private constructor. Use parse() to obtain an instance.
     *
     * @param int $value The unscaled value.
     * @param int $scale The scale.
     */
    private function __construct(int $value, int $scale)
    {
        $this->value = $value;
        $this->scale = $scale;
    }

    /**
     * @param string $number
     *
     * @return Decimal
     *
     * @throws \InvalidArgumentException If the number is invalid, or exceeds the size of an int on this platform.
     */
    public static function parse(string $number) : Decimal
    {
        if (preg_match('/^(\-?)([0-9]+)(?:\.([0-9]+))?$/', $number, $matches) !== 1) {
            throw new \InvalidArgumentException('Invalid number: ' . $number);
        }

        $sign = $matches[1];
        $integral = $matches[2];

        if (isset($matches[3])) {
            $fractional = rtrim($matches[3], '0');
        } else {
            $fractional = '';
        }

        $scale = strlen($fractional);

        $value = $integral . $fractional;
        $value = ltrim($value, '0');

        if ($value === '') {
            $value = '0';
        }

        $value = $sign . $value;

        $intValue = (int) $value;

        if ($value !== (string) $intValue) {
            throw new \InvalidArgumentException('Decimal number out of range for this platform: ' . $value);
        }

        return new Decimal($intValue, $scale);
    }

    /**
     * @param Decimal $that
     *
     * @return bool
     *
     * @throws \RangeException If the result exceeds the size of an int on this platform.
     */
    public function isLessThan(Decimal $that) : bool
    {
        $this->scaleValues($this, $that, $a, $b);

        return $a < $b;
    }

    /**
     * @param Decimal $that
     *
     * @return bool
     *
     * @throws \RangeException If the result exceeds the size of an int on this platform.
     */
    public function isGreaterThan(Decimal $that) : bool
    {
        $this->scaleValues($this, $that, $a, $b);

        return $a > $b;
    }

    /**
     * @param Decimal $that
     *
     * @return Decimal
     *
     * @throws \RangeException If the result exceeds the size of an int on this platform.
     */
    public function minus(Decimal $that) : Decimal
    {
        $this->scaleValues($this, $that, $a, $b);

        $value = $a - $b;

        if (is_float($value)) {
            throw new \RangeException('The subtraction result overflows.');
        }

        $scale = max($this->scale, $that->scale);

        while ($scale !== 0) {
            if ($value % 10 !== 0) {
                break;
            }

            $value /= 10;
            $scale--;
        }

        return new Decimal($value, $scale);
    }

    /**
     * @param Decimal $that
     *
     * @return bool
     *
     * @throws \RangeException If the result exceeds the size of an int on this platform.
     */
    public function isDivisibleBy(Decimal $that) : bool
    {
        $this->scaleValues($this, $that, $a, $b);

        return $a % $b === 0;
    }

    /**
     * @return bool
     */
    public function isNegativeOrZero() : bool
    {
        return $this->value <= 0;
    }

    /**
     * Puts the internal values of the given decimal numbers on the same scale.
     *
     * @param Decimal $x The first decimal number.
     * @param Decimal $y The second decimal number.
     * @param int     $a A variable to store the scaled integer value of $x.
     * @param int     $b A variable to store the scaled integer value of $y.
     *
     * @return void
     *
     * @throws \RangeException If the scaled value exceeds the size of an int range on this platform.
     */
    private function scaleValues(Decimal $x, Decimal $y, & $a, & $b) : void
    {
        $a = $x->value;
        $b = $y->value;

        if ($x->scale > $y->scale) {
            $b *= 10 ** ($x->scale - $y->scale);

            if (is_float($b)) {
                throw new \RangeException('The scaled result overflows.');
            }
        } elseif ($x->scale < $y->scale) {
            $a *= 10 ** ($y->scale - $x->scale);

            if (is_float($a)) {
                throw new \RangeException('The scaled result overflows.');
            }
        }
    }
}
