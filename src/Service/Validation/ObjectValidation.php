<?php

namespace App\Service\Validation;

use App\Service\Nagios\Objects\ObjectInterface;
use App\Util\ArrayReader;
use App\Util\ValidationResult;

/**
 * Class ObjectValidation
 */
class ObjectValidation extends AppValidation
{
    public function __construct()
    {
    }

    /**
     * @param string      $class The class without the namespace
     * @param ArrayReader $fields
     */
    public function validateCreation(string $class, ArrayReader $fields)
    {
        $class = class_basename(ObjectInterface::class) . '\\' . $class;

        $validationResult = new ValidationResult(__('Please check your data'));
        $this->validateClass($class, $validationResult);
        $this->validateFields($class, $fields, $validationResult);

        $this->throwOnError($validationResult);
    }

    /**
     * Validate if a class exists and can be used.
     *
     * @param string           $class
     * @param ValidationResult $validationResult
     */
    private function validateClass(string $class, ValidationResult $validationResult)
    {
        if (!class_exists($class)) {
            $validationResult->setError('object', __('Object was not found. Please select an existing object.'));
        }
    }

    /**
     * Validate if all fields that are required exist.
     *
     * @param string           $class
     * @param ArrayReader      $fields
     * @param ValidationResult $validationResult
     */
    private function validateFields(string $class, ArrayReader $fields, ValidationResult $validationResult)
    {
        $objectConfigurations = call_user_func($class . '::getObjectConfig');
        foreach ($objectConfigurations as $objectConfigurationClass => $objectConfiguration) {
            if ($objectConfiguration['required'] && $fields->exists(class_name($objectConfigurationClass)) === false) {
                $validationResult->setError('form', __('Please ensure that all required fields are filled in'));
            }
        }
    }
}
