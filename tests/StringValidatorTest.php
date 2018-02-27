<?php

namespace Brick\Validation\Tests;

use Brick\Validation\Validator\StringValidator;

/**
 * Unit tests for the String validator.
 */
class StringValidatorTest extends AbstractTestCase
{
    public function testDefault()
    {
        $validator = new StringValidator();

        $this->doTestValidator($validator, [
            ''           => [],
            'abc/def'    => [],
            'àéìòù 汉字'   => [],
        ]);
    }

    public function testMinLength()
    {
        $validator = new StringValidator(5, 0);

        $this->doTestValidator($validator, [
            ''             => ['validator.string.too-short'],
            'a'            => ['validator.string.too-short'],
            'àb'           => ['validator.string.too-short'],
            'abc'          => ['validator.string.too-short'],
            'àbcd'         => ['validator.string.too-short'],
            'abcde'        => [],
            'àbcde'        => [],
            'abcdef'       => [],
            'àbcdèfg'      => [],
            'abcdefg h'    => [],
            'àbcdèfg/hì'   => [],
            'abcdefghijk'  => [],
            'abcdefghijkl' => [],
            'abcdefghijk汉' => [],
        ]);
    }

    public function testMinMaxLength()
    {
        $validator = new StringValidator(5, 10);

        $this->doTestValidator($validator, [
            ''             => ['validator.string.too-short'],
            'a'            => ['validator.string.too-short'],
            'àb'           => ['validator.string.too-short'],
            'abc'          => ['validator.string.too-short'],
            'àbcd'         => ['validator.string.too-short'],
            'abcde'        => [],
            'àbcde'        => [],
            'abcdef'       => [],
            'àbcdèfg'      => [],
            'abcdefg h'    => [],
            'àbcdèfg/汉字'   => [],
            'abcdefg/汉字k'  => ['validator.string.too-long'],
            'abcdefghijkl' => ['validator.string.too-long']
        ]);
    }

    public function testInvalidUTF8()
    {
        $invalidStrings = [
            /* illegal char */
            "\xFF",
            "\xFF\x80",

            /* 10bbbbbb can only appear after 11bbbbbb */
            "\x80",
            "\x80\x80",

            /* 110bbbbb should be followed by 10bbbbbb */
            "\xC0",
            "\xC0\x7F",

            /* 1110bbbb should be followed by 2x 10bbbbbb */
            "\xE0",
            "\xE0\x7F",
            "\xE0\x80",
            "\xE0\x7F\x80",
            "\xE0\x80\x7F",

            /* 11110bbb should be followed by 3x 10bbbbbb */
            "\xF0",
            "\xF0\x7F",
            "\xF0\x80",
            "\xF0\x7F\x80",
            "\xF0\x80\x7F",
            "\xF0\x80\x80",
            "\xF0\x7F\x80\x80",
            "\xF0\x80\x7F\x80",
            "\xF0\x80\x80\x7F",
        ];

        $tests = [];
        foreach ($invalidStrings as $invalidString) {
            $tests[$invalidString] = ['validator.string.encoding'];
        }

        $validator = new StringValidator();
        $this->doTestValidator($validator, $tests);
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
