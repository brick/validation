<?php

declare(strict_types=1);

namespace Brick\Validation\Validator;

use Brick\Validation\AbstractValidator;

/**
 * Validates a UTF-8 string.
 */
class StringValidator extends AbstractValidator
{
    /**
     * @var int
     */
    private $minLength;

    /**
     * @var int
     */
    private $maxLength;

    /**
     * @param int $minLength The minimum string length, or zero for no minimum.
     * @param int $maxLength The maximum string length, or zero for no maximum.
     */
    public function __construct(int $minLength = 0, int $maxLength = 0)
    {
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
    }

    /**
     * {@inheritdoc}
     */
    public function getPossibleMessages() : array
    {
        return [
            'validator.string.encoding'  => 'The string is not valid UTF-8.',
            'validator.string.too-short' => 'The string is too short.',
            'validator.string.too-long'  => 'The string is too long.',
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function validate(string $value) : void
    {
        $length = $this->getLength($value);

        if ($length === null) {
            $this->addFailureMessage('validator.string.encoding');

            return;
        }

        if ($this->minLength && $length < $this->minLength) {
            $this->addFailureMessage('validator.string.too-short');
        } elseif ($this->maxLength && $length > $this->maxLength) {
            $this->addFailureMessage('validator.string.too-long');
        }
    }

    /**
     * Returns the length of the given string, or null if not a valid UTF-8 string.
     *
     * @param string $string
     *
     * @return int|null
     */
    private function getLength(string $string) : ?int
    {
        if (extension_loaded('mbstring')) {
            if (! mb_check_encoding($string, 'UTF-8')) {
                return null;
            }

            return mb_strlen($string, 'UTF-8');
        }

        $charLength = 0;

        $length = strlen($string);

        for ($i = 0; $i < $length; $i++) {
            $charLength++;

            $char = ord($string[$i]);

            if ($char < 0x80) { // 0bbbbbbb
                continue;
            }

            if (($char & 0xE0) === 0xC0) { // 110bbbbb
                $n = 1;
            } elseif (($char & 0xF0) === 0xE0) { // 1110bbbb
                $n = 2;
            } elseif (($char & 0xF0) === 0xF0) { // 1111bbbb
                $n = 3;
            } else { // invalid char
                return null;
            }

            for ($j = 0; $j < $n; $j++) {
                if (++$i === $length) { // unexpected end of string
                    return null;
                }

                if ((ord($string[$i]) & 0xC0) !== 0x80) { // does not match 10bbbbbb
                    return null;
                }
            }
        }

        return $charLength;
    }
}
