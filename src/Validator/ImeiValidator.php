<?php

namespace Brick\Validation\Validator;

use Brick\Validation\AbstractValidator;
use Brick\Validation\Internal\Luhn;

/**
 * Validates the IMEI number of a mobile device.
 */
class ImeiValidator extends AbstractValidator
{
    /**
     * {@inheritdoc}
     */
    public function getPossibleMessages() : array
    {
        return [
            'validator.imei.invalid' => 'Invalid IMEI number.'
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function validate(string $value) : void
    {
        if (! Luhn::isValid($value) || strlen($value) != 15) {
            $this->addFailureMessage('validator.imei.invalid');
        }
    }
}
