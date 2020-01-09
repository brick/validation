<?php

declare(strict_types=1);

namespace Brick\Validation\Tests;

use Brick\Validation\Validator\DigitValidator;

/**
 * Unit tests for the digit validator.
 */
class DigitValidatorTest extends AbstractTestCase
{
    /**
     * @dataProvider providerDigitValidator
     */
    public function testDigitValidator(string $input, array $output) : void
    {
        $validator = new DigitValidator();

        $this->doTestValidator($validator, $input, $output);
    }

    public function providerDigitValidator() : array
    {
        return $this->convertLegacyTests([
            '0123456789'                     => [],
            '012345678901234567890123456789' => [],

            ''   => ['validator.digit.invalid'],
            ' 0' => ['validator.digit.invalid'],
            '0 ' => ['validator.digit.invalid'],

            '123.456' => ['validator.digit.invalid'],
            '123A'    => ['validator.digit.invalid']
        ]);
    }
}
