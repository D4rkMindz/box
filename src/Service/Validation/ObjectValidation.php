<?php

namespace App\Service\Validation;

use App\Service\API\APIObjectService;
use App\Service\Nagios\Objects\ObjectInterface;
use App\Util\ArrayReader;
use App\Util\ValidationResult;

/**
 * Class ObjectValidation
 */
class ObjectValidation extends AppValidation
{
    /** @var APIObjectService */
    private $api;

    /**
     * ObjectValidation constructor.
     *
     * @param APIObjectService $api
     */
    public function __construct(APIObjectService $api)
    {
        $this->api = $api;
    }

    /**
     * Validate the creation of a box
     *
     * @param string      $class The class without the namespace
     * @param int         $companyId
     * @param int         $boxId
     * @param ArrayReader $fields
     */
    public function validateCreation(string $class, int $companyId, int $boxId, ArrayReader $fields)
    {
        $class = class_basename(ObjectInterface::class) . '\\' . $class;

        $validationResult = new ValidationResult(__('Please check your data'));
        $this->validateClass($class, $validationResult);
        $this->validateIfCreationIsAllowed($companyId, $boxId, $validationResult);
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

    /**
     * Check if another creation is allowed
     *
     * @param int              $companyId
     * @param int              $boxId
     * @param ValidationResult $validationResult
     */
    private function validateIfCreationIsAllowed(int $companyId, int $boxId, ValidationResult $validationResult)
    {
        if (!$this->api->canCreate($companyId, $boxId)) {
            $validationResult->setError('quota',
                __('Your object quota exceeded. Please choose a higher subscription plan.'));
        }
    }
}
