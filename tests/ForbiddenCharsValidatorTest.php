<?php

namespace Brick\Validation\Tests;

use Brick\Validation\Validator\ForbiddenCharsValidator;

/**
 * Unit tests for the forbidden chars validator.
 */
class ForbiddenCharsValidatorTest extends AbstractTestCase
{
    /**
     * @dataProvider providerForbiddenCharsValidator
     */
    public function testForbiddenCharsValidator(string $input, array $output) : void
    {
        $validator = new ForbiddenCharsValidator('<>');

        $this->doTestValidator($validator, $input, $output);
    }

    public function providerForbiddenCharsValidator() : array
    {
        return $this->convertLegacyTests([
            ''     => [],
            'abc'  => [],
            'a b'  => [],
            'a<b'  => ['validator.forbidden-chars'],
            'a>b'  => ['validator.forbidden-chars'],
            '<a>'  => ['validator.forbidden-chars'],
            '</a>' => ['validator.forbidden-chars'],
        ]);
    }
}
