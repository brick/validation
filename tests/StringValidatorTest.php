<?php

namespace Brick\Validation\Tests;

use Brick\Validation\Validator\StringValidator;

/**
 * Unit tests for the String validator.
 */
class StringValidatorTest extends AbstractTestCase
{
    public function testStringValidator()
    {
        $validator = new StringValidator();

        $this->doTestValidator($validator, [
            ''   => [],
        ]);
    }

    public function testStringValidatorWithTooShortString()
    {
        $validator = new StringValidator(5, 0);

        $this->doTestValidator($validator, [
            '123' => ['validator.string.too-short'],
        ]);
    }

    public function testStringValidatorWithTooLongString()
    {
        $validator = new StringValidator(5, 10);

        $this->doTestValidator($validator, [
            '12345678910' => ['validator.string.too-long'],
        ]);
    }

    public function testStringValidatorWithNonUtf8String()
    {
        $validator = new StringValidator();

        $this->doTestValidator($validator, [
            base64_decode('q6LFb6VArMkK') => ['validator.string.encoding'],
        ]);
    }

    public function testGetPossibleMessages()
    {
        $validator = new StringValidator();
        $result = $validator->getPossibleMessages();

        $this->assertArrayHasKey('validator.string.encoding', $result);
        $this->assertArrayHasKey('validator.string.too-short', $result);
        $this->assertArrayHasKey('validator.string.too-long', $result);
        $this->assertContains('The string is not valid UTF-8.', $result);
        $this->assertContains('The string is too short.', $result);
        $this->assertContains('The string is too long.', $result);
    }
}
