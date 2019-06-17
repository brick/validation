<?php

namespace Brick\Validation\Tests;

use Brick\Validation\Validator\PatternValidator;

/**
 * Unit tests for the pattern validator.
 */
class PatternValidatorTest extends AbstractTestCase
{
    /**
     * @dataProvider providerPatternValidator
     */
    public function testPatternValidator(string $input, array $output) : void
    {
        $validator = new PatternValidator('[0-9a-z]{2}');

        $this->doTestValidator($validator, $input, $output);
    }

    public function providerPatternValidator() : array
    {
        return $this->convertLegacyTests([
            'ab' => [],
            'a0' => [],
            '0a' => [],

            ''    => ['validator.pattern.no-match'],
            'a'   => ['validator.pattern.no-match'],
            'Ab'  => ['validator.pattern.no-match'],
            'aB'  => ['validator.pattern.no-match'],
            'AB'  => ['validator.pattern.no-match'],
            'abc' => ['validator.pattern.no-match'],
            ' ab' => ['validator.pattern.no-match'],
            'ab ' => ['validator.pattern.no-match']
        ]);
    }
}
