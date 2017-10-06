<?php

namespace Brick\Validation;

/**
 * Interface that all validators must implement.
 */
interface Validator
{
    /**
     * Returns whether the given value is valid.
     *
     * @param string $value The value to validate.
     *
     * @return bool `true` if the value is valid, `false` otherwise.
     */
    public function isValid(string $value) : bool;

    /**
     * Returns the failure messages from the last validation.
     *
     * Keys are unique identifiers to the message, values are the failure message in English.
     *
     * @return array The last failure messages.
     */
    public function getFailureMessages() : array;

    /**
     * Returns all possible failure messages for this validator.
     *
     * Keys are unique identifiers to the message, values are the failure message in English.
     *
     * @return array
     */
    public function getPossibleMessages() : array;
}
