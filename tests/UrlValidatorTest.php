<?php

namespace Brick\Validation\Tests;

use Brick\Validation\Validator\UrlValidator;

/**
 * Unit tests for the URL validator.
 */
class UrlValidatorTest extends AbstractTestCase
{
    /**
     * @dataProvider providerUrlValidator
     */
    public function testUrlValidator(string $input, array $output) : void
    {
        $validator = new UrlValidator();

        $this->doTestValidator($validator, $input, $output);
    }

    public function providerUrlValidator() : array
    {
        return $this->convertLegacyTests([
            ''                    => ['validator.url.invalid'],
            'http'                => ['validator.url.invalid'],
            'http:'               => ['validator.url.invalid'],
            'http:test.com'       => ['validator.url.invalid'],
            'http:test.com/test'  => ['validator.url.invalid'],
            'http:/'              => ['validator.url.invalid'],
            'http:/test.com'      => ['validator.url.invalid'],
            'http:/test.com/test' => ['validator.url.invalid'],
            'http://user@:80'     => ['validator.url.invalid'],

            'http://test.com'                        => [],
            'http://test.com/'                       => [],
            'https://test.com/test?a=b'              => [],
            'https://test.com/test?a=b&c=d'          => [],
            'https://test.com/test?a=b&c=d#fragment' => [],
            'ftp://user:pass@example.com'            => [],
            'ftp://user:pass@example.com/a/b'        => [],
        ]);
    }
}
