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
     * @param Validator $validator The validator under test.
     * @param array     $tests     The values to test, along with the expected results.
     *
     * @return void
     */
    final protected function doTestValidator(Validator $validator, array $tests)
    {
        $testNumber = 1;

        foreach ($tests as $value => $expectedFailureMessageKeys) {
            $isValid = $validator->isValid($value);
            $failureMessages = $validator->getFailureMessages();
            $failureMessageKeys = array_keys($failureMessages);

            $message = sprintf(
                'Test number %d ("%s"): expected %s, got %s',
                $testNumber,
                $value,
                json_encode($expectedFailureMessageKeys),
                json_encode($failureMessageKeys)
            );

            $this->assertSame($expectedFailureMessageKeys === [], $isValid, $message);
            $this->assertSame($expectedFailureMessageKeys, $failureMessageKeys, $message);

            $testNumber++;
        }
    }
}
