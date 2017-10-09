<?php

declare(strict_types=1);

namespace Brick\Validation\Validator;

use Brick\Validation\AbstractValidator;
use Brick\Validation\Internal\Decimal;

/**
 * Validates a number.
 *
 * Integer and decimal numbers are supported. Both are represented as integers internally, so the maximum number of
 * digits supported depends on the int size of the platform.
 */
class NumberValidator extends AbstractValidator
{
    /**
     * The minimum value, or null for no minimum.
     *
     * @var Decimal|null
     */
    private $min;

    /**
     * The maximum value, or null for no maximum.
     *
     * @var Decimal|null
     */
    private $max;

    /**
     * The step, or null for no constraint.
     *
     * @var Decimal|null
     */
    private $step;

    /**
     * {@inheritdoc}
     */
    public function getPossibleMessages() : array
    {
        return [
            'validator.number.invalid'  => 'The number is not valid.',
            'validator.number.overflow' => 'The number is not supported.',
            'validator.number.min'      => 'The number is too small.',
            'validator.number.max'      => 'The number is too large.',
            'validator.number.step'     => 'The number is not an acceptable value.',
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function validate(string $value) : void
    {
        try {
            $value = Decimal::parse($value);
        } catch (\InvalidArgumentException $e) {
            $this->addFailureMessage('validator.number.invalid');

            return;
        }

        try {
            if ($this->min !== null && $value->isLessThan($this->min)) {
                $this->addFailureMessage('validator.number.min');

                return;
            }

            if ($this->max !== null && $value->isGreaterThan($this->max)) {
                $this->addFailureMessage('validator.number.max');

                return;
            }

            if ($this->step !== null) {
                if ($this->min !== null) {
                    $value = $value->minus($this->min);
                }

                if (! $value->isDivisibleBy($this->step)) {
                    $this->addFailureMessage('validator.number.step');
                }
            }
        } catch (\RangeException $e) {
            $this->addFailureMessage('validator.number.overflow');
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
            $min = Decimal::parse($min);
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
            $max = Decimal::parse($max);
        }

        $this->max = $max;

        return $this;
    }

    /**
     * @param string|null $step The step, or null to remove it.
     *
     * @return NumberValidator
     *
     * @throws \InvalidArgumentException If not a valid number or not positive.
     */
    public function setStep(?string $step) : self
    {
        if ($step !== null) {
            $step = Decimal::parse($step);

            if ($step->isNegativeOrZero()) {
                throw new \InvalidArgumentException('The step must be strictly positive.');
            }
        }

        $this->step = $step;

        return $this;
    }
}
