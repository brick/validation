<?php

declare(strict_types=1);

namespace Brick\Validation\Validator;

use Brick\Validation\AbstractValidator;

/**
 * Validates a string of digits.
 */
class DigitValidator extends AbstractValidator
{
    /**
     * {@inheritdoc}
     */
    public function getPossibleMessages() : array
    {
        return [
            'validator.digit.invalid' => 'All characters must be digits.'
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function validate(string $value) : void
    {
        if (! ctype_digit($value)) {
            $this->addFailureMessage('validator.digit.invalid');
        }
    }
}
