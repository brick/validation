<?php

declare(strict_types=1);

namespace Brick\Validation\Tests;

use Brick\Validation\Validator\TimeValidator;

/**
 * Unit tests for the time validator.
 */
class TimeValidatorTest extends AbstractTestCase
{
    /**
     * @dataProvider providerTimeValidator
     */
    public function testTimeValidator(string $input, array $output) : void
    {
        $validator = new TimeValidator();

        $this->doTestValidator($validator, $input, $output);
    }

    public function providerTimeValidator() : array
    {
        return $this->convertLegacyTests([
            ''            => ['validator.time.invalid-format'],
            '0'           => ['validator.time.invalid-format'],
            '00'          => ['validator.time.invalid-format'],
            '00:'         => ['validator.time.invalid-format'],
            '00:0'        => ['validator.time.invalid-format'],
            '00:00'       => [],
            '00:00:'      => ['validator.time.invalid-format'],
            '00:00:0'     => ['validator.time.invalid-format'],
            '00:00:00'    => [],
            '00:00:00:'   => ['validator.time.invalid-format'],
            '00:00:00:0'  => ['validator.time.invalid-format'],
            '00:00:00:00' => ['validator.time.invalid-format'],

            ' 00:00' => ['validator.time.invalid-format'],
            '00:00 ' => ['validator.time.invalid-format'],

            '23:59' => [],
            '23:60' => ['validator.time.invalid-time'],
            '24:00' => ['validator.time.invalid-time'],

            '23:59:59' => [],
            '23:60:00' => ['validator.time.invalid-time'],
            '23:00:60' => ['validator.time.invalid-time'],
            '24:00:00' => ['validator.time.invalid-time']
        ]);
    }
}
