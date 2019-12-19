<?php

namespace App\Service\Nagios;

use App\Service\Nagios\Objects\Config\ObjectConfigInterface;
use App\Service\Nagios\Objects\ObjectInterface;

/**
 * Class ObjectParser
 */
class ObjectParser
{
    /**
     * @param ObjectInterface $object
     *
     * @return string
     */
    public function convertObjectToJson(ObjectInterface $object)
    {
        $name = $object->getName();
        $type = $this->parseType($object);
        $required = $this->parseRequiredFields($object);
        $config = $this->parseConfiguration($object);
        $configuration = [
            'name' => $name,
            'type' => $type,
            'required' => $required,
            'config' => $config,
        ];
        $json = json_encode($configuration, JSON_THROW_ON_ERROR);

        return $json;
    }

    /**
     * Parse the filename
     *
     * @param ObjectInterface $object
     *
     * @return string
     */
    public function parseFilename(ObjectInterface $object): string
    {
        return $this->parseType($object) . '_' . $object->getName();
    }

    /**
     * Get all required fields
     *
     * @param ObjectInterface $object
     *
     * @return array
     */
    private function parseRequiredFields(ObjectInterface $object): array
    {
        $required = [];
        $configurations = $object::getObjectConfig();
        foreach ($configurations as $objectConfigClass => $configuration) {
            if ($configuration['required']) {
                $required[] = call_user_func([$objectConfigClass, 'getTemplateVariableName']);
            }
        }

        return $required;
    }

    /**
     * @param ObjectInterface $object
     *
     * @return array
     */
    private function parseConfiguration(ObjectInterface $object): array
    {
        $objectConfigurations = $object->getConfig();
        $config = [];

        /** @var ObjectConfigInterface $objectConfiguration */
        foreach ($objectConfigurations as $objectConfiguration) {
            $config[] = [
                'type' => $objectConfiguration::getTemplateVariableName(),
                'value' => $objectConfiguration->getValue(),
            ];
        }

        return $config;
    }

    /**
     * Parse the type of the object
     *
     * @param ObjectInterface $object
     *
     * @return string
     */
    private function parseType(ObjectInterface $object)
    {
        return class_name(get_class($object));
    }

}
