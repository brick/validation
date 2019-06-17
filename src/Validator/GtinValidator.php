<?php

declare(strict_types=1);

namespace Brick\Validation\Validator;

use Brick\Validation\AbstractValidator;

/**
 * Validates a GTIN (UPC, EAN, ISBN).
 *
 * GTIN numbers can have 4 lengths: GTIN-8, GTIN-12, GTIN-13 or GTIN-14.
 * Conversion to a greater length involves simple left-padding with zeros.
 *
 * https://www.gs1.org/services/check-digit-calculator
 */
class GtinValidator extends AbstractValidator
{
    /**
     * {@inheritdoc}
     */
    public function getPossibleMessages() : array
    {
        return [
            'validator.gtin.invalid' => 'Invalid GTIN number.'
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function validate(string $value) : void
    {
        if (! $this->doValidate($value)) {
            $this->addFailureMessage('validator.gtin.invalid');
        }
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    private function doValidate(string $value) : bool
    {
        if (preg_match('/^(?:[0-9]{8}|[0-9]{12,14})$/', $value) !== 1) {
            return false;
        }

        return $this->calculateCheckDigit(substr($value, 0, -1)) === $value[-1];
    }

    /**
     * @param string $number
     *
     * @return string
     */
    private function calculateCheckDigit(string $number) : string
    {
        $length = strlen($number);
        $offset = $length % 2;

        for ($sum = 0, $i = 0; $i < $length; $i++) {
            $sum += $number[$i] * (1 + 2 * (($i + $offset) % 2));
        }

        return (string) ((10 - ($sum % 10)) % 10);
    }
}
