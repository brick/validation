<?php

declare(strict_types=1);

namespace Brick\Validation\Validator;

use Brick\Validation\AbstractValidator;

/**
 * Validates an RFC 3339 date.
 */
class DateValidator extends AbstractValidator
{
    /**
     * {@inheritdoc}
     */
    public function getPossibleMessages() : array
    {
        return [
            'validator.date.invalid-format' => 'The date format is not valid.',
            'validator.date.invalid-date'   => 'The date is not a valid date.'
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function validate(string $value) : void
    {
        if (preg_match('/^([0-9]{4})\-([0-9]{2})\-([0-9]{2})$/', $value, $matches) == 0) {
            $this->addFailureMessage('validator.date.invalid-format');

            return;
        }

        [, $year, $month, $day] = $matches;

        $year  = (int) $year;
        $month = (int) $month;
        $day   = (int) $day;

        if (! $this->isDateValid($year, $month, $day)) {
            $this->addFailureMessage('validator.date.invalid-date');
        }
    }

    /**
     * @param int $year
     * @param int $month
     * @param int $day
     *
     * @return bool
     */
    private function isDateValid(int $year, int $month, int $day) : bool
    {
        if ($day == 0) {
            return false;
        }

        switch ($month) {
            case 2:
                $days = $this->isLeapYear($year) ? 29 : 28;
                break;

            case 4:
            case 6:
            case 9:
            case 11:
                $days = 30;
                break;

            case 1:
            case 3:
            case 5:
            case 7:
            case 8:
            case 10:
            case 12:
                $days = 31;
                break;

            default:
                return false;
        }

        return $day <= $days;
    }

    /**
     * @param int $year
     *
     * @return bool
     */
    private function isLeapYear(int $year) : bool
    {
        return (($year & 3) == 0) && (($year % 100) != 0 || ($year % 400) == 0);
    }
}
