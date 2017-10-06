<?php

declare(strict_types=1);

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
     * Keys are unique message identifiers, values are failure messages in English.
     * Unique message identifiers can be used for translation.
     *
     * If the last validation was successful, or if no validation has been performed yet, an empty array is returned.
     * If the last validation was unsuccessful, the result array contains at least one failure message.
     *
     * @return array The last failure messages.
     */
    public function getFailureMessages() : array;

    /**
     * Returns all possible failure messages for this validator.
     *
     * Keys are unique message identifiers, values are failures message in English.
     * This method is useful to integrate all possible error messages in a translation system.
     *
     * @return array
     */
    public function getPossibleMessages() : array;
}
