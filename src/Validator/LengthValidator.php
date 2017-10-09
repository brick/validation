<?php

declare(strict_types=1);

namespace Brick\Validation\Validator;

use Brick\Validation\AbstractValidator;

/**
 * Validates the length of a string.
 *
 * @deprecated Use StringValidator
 */
class LengthValidator extends AbstractValidator
{
    /**
     * @var int|null
     */
    private $minLength;

    /**
     * @var int|null
     */
    private $maxLength;

    /**
     * {@inheritdoc}
     */
    public function getPossibleMessages() : array
    {
        return [
            'validator.length.too-short' => 'The string is too short.',
            'validator.length.too-long'  => 'The string is too long.'
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function validate(string $value) : void
    {
        $length = strlen($value);

        if ($this->minLength !== null && $length < $this->minLength) {
            $this->addFailureMessage('validator.length.too-short');
        } elseif ($this->maxLength !== null && $length > $this->maxLength) {
            $this->addFailureMessage('validator.length.too-long');
        }
    }

    /**
     * Sets a minimum length.
     *
     * @param int $minLength
     *
     * @return LengthValidator
     */
    public function setMinLength(int $minLength) : self
    {
        $this->minLength = $minLength;

        return $this;
    }

    /**
     * Sets a maximum length.
     *
     * @param int $maxLength
     *
     * @return LengthValidator
     */
    public function setMaxLength(int $maxLength) : self
    {
        $this->maxLength = $maxLength;

        return $this;
    }

    /**
     * Sets an exact length.
     *
     * @param int $length
     *
     * @return LengthValidator
     */
    public function setLength(int $length) : self
    {
        $this->minLength = $length;
        $this->maxLength = $length;

        return $this;
    }
}
