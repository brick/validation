<?php

namespace Brick\Validation\Tests;

use Brick\Validation\Validator\NumberValidator;

/**
 * Unit tests for the number validator.
 */
class NumberValidatorTest extends AbstractTestCase
{
    public function testValidNumbers()
    {
        $validator = new NumberValidator();

        $this->doTestValidator($validator, [
            '1'    => [],
            '1.23' => [],
            'test' => ['validator.number.invalid'],
            ''     => ['validator.number.invalid'],
            ' 0'   => ['validator.number.invalid'],
            '0 '   => ['validator.number.invalid']
        ]);
    }

    public function testMin()
    {
        $validator = new NumberValidator();
        $validator->setMin(1);

        $this->doTestValidator($validator, [
            '0' => ['validator.number.min'],
            '1' => [],
            '2' => [],

            '0.99' => ['validator.number.min'],
            '1.00' => [],
            '1.01' => []
        ]);
    }

    public function testMax()
    {
        $validator = new NumberValidator();
        $validator->setMax(1);

        $this->doTestValidator($validator, [
            '0' => [],
            '1' => [],
            '2' => ['validator.number.max'],

            '0.99' => [],
            '1.00' => [],
            '1.01' => ['validator.number.max']
        ]);
    }

    public function testStep()
    {
        $validator = new NumberValidator();
        $validator->setStep(2);

        $this->doTestValidator($validator, [
            '0' => [],
            '1' => ['validator.number.step'],
            '2' => [],

            '1.99' => ['validator.number.step'],
            '2.00' => [],
            '2.01' => ['validator.number.step']
        ]);
    }

    public function testDecimalNumbers()
    {
        $validator = new NumberValidator();
        $validator->setMin('3.5');
        $validator->setMax('4.3');
        $validator->setStep('0.3');

        $this->doTestValidator($validator, [
            '0' => ['validator.number.min'],
            '1' => ['validator.number.min'],
            '2' => ['validator.number.min'],
            '3' => ['validator.number.min'],
            '3.1' => ['validator.number.min'],
            '3.2' => ['validator.number.min'],
            '3.3' => ['validator.number.min'],
            '3.4' => ['validator.number.min'],
            '3.5' => [],
            '3.6' => ['validator.number.step'],
            '3.7' => ['validator.number.step'],
            '3.8' => [],
            '3.9' => ['validator.number.step'],
            '4.0' => ['validator.number.step'],
            '4.1' => [],
            '4.2' => ['validator.number.step'],
            '4.3' => ['validator.number.step'],
            '4.4' => ['validator.number.max'],
            '4.5' => ['validator.number.max'],
            '4.6' => ['validator.number.max'],
            '4.7' => ['validator.number.max'],
            '4.8' => ['validator.number.max'],
            '4.9' => ['validator.number.max'],
            '5.0' => ['validator.number.max'],
        ]);

        $validator->setMin('-0.1');
        $validator->setMax('0.7');

        $this->doTestValidator($validator, [
            '-0.4' => ['validator.number.min'],
            '-0.3' => ['validator.number.min'],
            '-0.2' => ['validator.number.min'],
            '-0.1' => [],
            '0' => ['validator.number.step'],
            '0.1' => ['validator.number.step'],
            '0.2' => [],
            '0.3' => ['validator.number.step'],
            '0.4' => ['validator.number.step'],
            '0.5' => [],
            '0.6' => ['validator.number.step'],
            '0.7' => ['validator.number.step'],
            '0.8' => ['validator.number.max'],
            '0.9' => ['validator.number.max'],
            '1' => ['validator.number.max'],
        ]);
    }
}
