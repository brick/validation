<?php

declare(strict_types=1);

namespace Brick\Validation\Tests;

use Brick\Validation\Validator\LengthValidator;

/**
 * Unit tests for the length validator.
 */
class LengthValidatorTest extends AbstractTestCase
{
    /**
     * @dataProvider providerNoConstraintsByDefault
     */
    public function testNoConstraintsByDefault(string $input, array $output) : void
    {
        $validator = new LengthValidator();

        $this->doTestValidator($validator, $input, $output);
    }

    public function providerNoConstraintsByDefault() : array
    {
        return $this->convertLegacyTests([
            ''     => [],
            'a'    => [],
            'ab'   => [],
            'abc'  => [],
            'abcd' => []
        ]);
    }

    /**
     * @dataProvider providerMinLength
     */
    public function testMinLength(string $input, array $output) : void
    {
        $validator = new LengthValidator();
        $validator->setMinLength(2);

        $this->doTestValidator($validator, $input, $output);
    }

    public function providerMinLength() : array
    {
        return $this->convertLegacyTests([
            ''     => ['validator.length.too-short'],
            'a'    => ['validator.length.too-short'],
            'ab'   => [],
            'abc'  => [],
            'abcd' => []
        ]);
    }

    /**
     * @dataProvider providerMaxLength
     */
    public function testMaxLength(string $input, array $output) : void
    {
        $validator = new LengthValidator();
        $validator->setMaxLength(2);

        $this->doTestValidator($validator, $input, $output);
    }

    public function providerMaxLength() : array
    {
        return $this->convertLegacyTests([
            ''     => [],
            'a'    => [],
            'ab'   => [],
            'abc'  => ['validator.length.too-long'],
            'abcd' => ['validator.length.too-long']
        ]);
    }

    /**
     * @dataProvider providerMinAndMaxLength
     */
    public function testMinAndMaxLength(string $input, array $output) : void
    {
        $validator = new LengthValidator();
        $validator->setMinLength(1);
        $validator->setMaxLength(3);

        $this->doTestValidator($validator, $input, $output);
    }

    public function providerMinAndMaxLength() : array
    {
        return $this->convertLegacyTests([
            ''     => ['validator.length.too-short'],
            'a'    => [],
            'ab'   => [],
            'abc'  => [],
            'abcd' => ['validator.length.too-long']
        ]);
    }

    /**
     * @dataProvider providerExactLength
     */
    public function testExactLength(string $input, array $output) : void
    {
        $validator = new LengthValidator();
        $validator->setLength(2);

        $this->doTestValidator($validator, $input, $output);
    }

    public function providerExactLength() : array
    {
        return $this->convertLegacyTests([
            ''     => ['validator.length.too-short'],
            'a'    => ['validator.length.too-short'],
            'ab'   => [],
            'abc'  => ['validator.length.too-long'],
            'abcd' => ['validator.length.too-long']
        ]);
    }
}
