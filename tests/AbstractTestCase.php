<?php

namespace Brick\Validation\Tests;

use Brick\Validation\Validator;

use PHPUnit\Framework\TestCase;

/**
 * Base class for validation tests.
 */
abstract class AbstractTestCase extends TestCase
{
    /**
     * @param Validator $validator
     * @param string    $value
     * @param array     $expectedFailureMessageKeys
     *
     * @return void
     */
    final protected function doTestValidator(Validator $validator, string $value, array $expectedFailureMessageKeys) : void
    {
        $isValid = $validator->isValid($value);
        $failureMessages = $validator->getFailureMessages();
        $failureMessageKeys = array_keys($failureMessages);

        $message = sprintf(
            '"%s": expected %s, got %s',
            $value,
            json_encode($expectedFailureMessageKeys),
            json_encode($failureMessageKeys)
        );

        $this->assertSame($expectedFailureMessageKeys === [], $isValid, $message);
        $this->assertSame($expectedFailureMessageKeys, $failureMessageKeys, $message);
    }

    /**
     * Converts legacy key-value tests to a dataProvider-compatible array.
     *
     * @todo rewrite the tests and delete this
     *
     * @param array $tests
     *
     * @return array
     */
    final protected function convertLegacyTests(array $tests) : array
    {
        $result = [];

        foreach ($tests as $key => $value) {
            $result[] = [$key, $value];
        }

        return $result;
    }
}
