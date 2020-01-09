<?php

declare(strict_types=1);

namespace Brick\Validation\Tests;

use Brick\Validation\Validator\DateValidator;

/**
 * Unit tests for the date validator.
 */
class DateValidatorTest extends AbstractTestCase
{
    /**
     * @dataProvider providerDateValidator
     */
    public function testDateValidator(string $input, array $output) : void
    {
        $validator = new DateValidator();

        $this->doTestValidator($validator, $input, $output);
    }

    public function providerDateValidator() : array
    {
        return $this->convertLegacyTests([
            '2000-01-01' => [],
            '2000-01-AB' => ['validator.date.invalid-format'],
            '2000-1-1'   => ['validator.date.invalid-format'],
            '2000-11-01' => [],

            ' 2000-01-01' => ['validator.date.invalid-format'],
            '2000-01-01 ' => ['validator.date.invalid-format'],

            '2000-00-01' => ['validator.date.invalid-date'],
            '2000-13-01' => ['validator.date.invalid-date'],
            '2000-01-00' => ['validator.date.invalid-date'],
            '2000-01-32' => ['validator.date.invalid-date'],

            '2000-02-29' => [],
            '2001-02-28' => [],

            '2000-02-30' => ['validator.date.invalid-date'],
            '2001-02-29' => ['validator.date.invalid-date']
        ]);
    }
}
