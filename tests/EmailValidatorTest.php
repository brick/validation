<?php

declare(strict_types=1);

namespace Brick\Validation\Tests;

use Brick\Validation\Validator\EmailValidator;

/**
 * Unit tests for the email validator.
 */
class EmailValidatorTest extends AbstractTestCase
{
    /**
     * @dataProvider providerEmailValidator
     */
    public function testEmailValidator(string $input, array $output) : void
    {
        $validator = new EmailValidator();

        $this->doTestValidator($validator, $input, $output);
    }

    public function providerEmailValidator() : array
    {
        return $this->convertLegacyTests([
            '' => ['validator.email.invalid'],

            'test@test.com'   => [],
            'test@test.co.uk' => [],
            'test@test'       => [],

            'foo.bar@test.com'     => [],
            'foo-bar_baz@test.com' => [],
            '_foo_@test.com'       => [],

            ' test@test.com' => ['validator.email.invalid'],
            'test@test.com ' => ['validator.email.invalid'],

            'test@'            => ['validator.email.invalid'],
            '@test.com'        => ['validator.email.invalid'],
            'test@test.'       => ['validator.email.invalid'],
            'test@.test'       => ['validator.email.invalid'],
            'test@localhost '  => ['validator.email.invalid'],
            'test@foo_bar.com' => ['validator.email.invalid'],
        ]);
    }
}
