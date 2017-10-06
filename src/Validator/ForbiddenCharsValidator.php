<?php

declare(strict_types=1);

namespace Brick\Validation\Validator;

use Brick\Validation\AbstractValidator;

/**
 * Validates that a string does not contain forbidden characters.
 */
class ForbiddenCharsValidator extends AbstractValidator
{
    /**
     * @var string
     */
    private $forbiddenChars;

    /**
     * {@inheritdoc}
     */
    public function getPossibleMessages() : array
    {
        return [
            'validator.forbidden-chars' => 'Invalid characters in the string.'
        ];
    }

    /**
     * Class constructor.
     *
     * @param string $forbiddenChars A string containing all forbidden characters.
     */
    public function __construct(string $forbiddenChars)
    {
        $this->forbiddenChars = $forbiddenChars;
    }

    /**
     * {@inheritdoc}
     */
    protected function validate(string $value) : void
    {
        $regexp = '/[' . preg_quote($this->forbiddenChars, '/') . ']/';

        if (preg_match($regexp, $value) != 0) {
            $this->addFailureMessage('validator.forbidden-chars');
        }
    }
}
