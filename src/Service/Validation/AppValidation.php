<?php

namespace App\Service\Validation;

use App\Exception\ValidationException;
use App\Util\ValidationResult;

/**
 * Class AppValidation.
 */
abstract class AppValidation
{
    /**
     * Throw a validation exception if the validation result fails.
     *
     * @param ValidationResult $validationResult
     */
    protected function throwOnError(ValidationResult $validationResult)
    {
        if ($validationResult->fails()) {
            throw new ValidationException($validationResult);
        }
    }

    /**
     * Validate the minimum length of a string.
     *
     * @param string $value
     * @param string $field
     * @param ValidationResult $validationResult
     * @param int $length
     */
    protected function validateLengthMin(string $value, string $field, ValidationResult $validationResult, int $length)
    {
        if (strlen(trim($value)) < $length) {
            $validationResult->setError($field, sprintf(__('Minimum length is %s'), $length));
        }
    }

    /**
     * Validate the maximum length of a string.
     *
     * @param string $value
     * @param string $field
     * @param ValidationResult $ValidationResult
     * @param int $length
     */
    protected function validateLengthMax(string $value, string $field, ValidationResult $ValidationResult, int $length)
    {
        if (strlen(trim($value)) > $length) {
            $ValidationResult->setError($field, sprintf(__('Maximum length is %s'), $length));
        }
    }
}
