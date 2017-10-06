<?php

declare(strict_types=1);

namespace Brick\Validation\Validator;

use Brick\Validation\AbstractValidator;

/**
 * Validates a regular expression pattern.
 */
class PatternValidator extends AbstractValidator
{
    /**
     * @var string
     */
    private $pattern;

    /**
     * {@inheritdoc}
     */
    public function getPossibleMessages() : array
    {
        return [
            'validator.pattern.no-match' => 'The string does not match the given pattern.'
        ];
    }

    /**
     * Class constructor.
     *
     * @param string $pattern
     */
    public function __construct(string $pattern)
    {
        $this->pattern = '/^(?:' . str_replace('/', '\/', $pattern) . ')$/';
    }

    /**
     * {@inheritdoc}
     */
    protected function validate(string $value) : void
    {
        if (preg_match($this->pattern, $value) !== 1) {
            $this->addFailureMessage('validator.pattern.no-match');
        }
    }
}
