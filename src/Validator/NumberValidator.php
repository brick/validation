<?php

declare(strict_types=1);

namespace Brick\Validation\Validator;

use Brick\Validation\AbstractValidator;

/**
 * Validates a number.
 */
class NumberValidator extends AbstractValidator
{
    /**
     * The minimum value, or null for no minimum.
     *
     * @var string|null
     */
    private $min = null;

    /**
     * The maximum value, or null for no maximum.
     *
     * @var string|null
     */
    private $max = null;

    /**
     * The step, or null for no constraint.
     *
     * @var string|null
     */
    private $step = null;

    /**
     * {@inheritdoc}
     */
    public function getPossibleMessages() : array
    {
        return [
            'validator.number.invalid' => 'The number is not valid.',
            'validator.number.min'     => 'The number is too small.',
            'validator.number.max'     => 'The number is too large.',
            'validator.number.step'    => 'The number is not an acceptable value.',
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function validate(string $value) : void
    {
        try {
            $value = $this->getNumber($value);
        } catch (\InvalidArgumentException $e) {
            $this->addFailureMessage('validator.number.invalid');

            return;
        }

        $value = (float) $value;

        if ($this->min !== null && $value < (float) $this->min) {
            $this->addFailureMessage('validator.number.min');
        } elseif ($this->max !== null && $value > (float) $this->max) {
            $this->addFailureMessage('validator.number.max');
        } elseif ($this->step !== null) {
            if ($this->min !== null) {
                $value -= (float) $this->min;
            }

            $fmod = (string) fmod($value, (float) $this->step);

            if ($fmod !== '0' && $fmod !== $this->step) {
                $this->addFailureMessage('validator.number.step');
            }
        }
    }

    /**
     * @param string|null $min The minimum value, or null to remove it.
     *
     * @return NumberValidator
     *
     * @throws \InvalidArgumentException If not a valid number.
     */
    public function setMin(?string $min) : self
    {
        if ($min !== null) {
            $min = $this->getNumber($min);
        }

        $this->min = $min;

        return $this;
    }

    /**
     * @param string|null $max The maximum value, or null to remove it.
     *
     * @return NumberValidator
     *
     * @throws \InvalidArgumentException If not a valid number.
     */
    public function setMax(?string $max) : self
    {
        if ($max !== null) {
            $max = $this->getNumber($max);
        }

        $this->max = $max;

        return $this;
    }

    /**
     * @param number|string|null $step The step, or null to remove it.
     *
     * @return NumberValidator
     *
     * @throws \InvalidArgumentException If the step is not a valid number or not positive.
     */
    public function setStep(?string $step) : self
    {
        if ($step !== null) {
            $step = $this->getNumber($step);

            if ($step === '0' || $step[0] === '-') {
                throw new \InvalidArgumentException('The step must be strictly positive.');
            }
        }

        $this->step = $step;

        return $this;
    }

    /**
     * Returns a canonical version of the given number.
     *
     * Leading zeros are removed in the integral part, and trailing zeros are removed in the fractional part.
     *
     * @param string $number
     *
     * @return string
     *
     * @throws \InvalidArgumentException If the number is not valid.
     */
    private function getNumber(string $number) : string
    {
        if (preg_match('/^(\-?)([0-9]+)(?:\.([0-9]+))?$/', $number, $matches) !== 1) {
            throw new \InvalidArgumentException('Invalid number: ' . $number);
        }

        $sign = $matches[1];

        $integral = ltrim($matches[2], '0');

        if ($integral === '') {
            $integral = '0';
        }

        if (isset($matches[3])) {
            $fractional = rtrim($matches[3], '0');
        } else {
            $fractional = '';
        }

        if ($integral === '0' && $fractional === '') {
            $sign = '';
        }

        $number = $sign . $integral;

        if ($fractional !== '') {
            $number .= '.' . $fractional;
        }

        return $number;
    }
}
