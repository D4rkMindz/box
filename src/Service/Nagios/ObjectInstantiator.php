<?php

namespace App\Service\Nagios;

use App\Service\Nagios\Objects\ObjectInterface;
use App\Util\ArrayReader;
use InvalidArgumentException;
use ReflectionClass;

/**
 * Class ObjectInstantiator
 */
class ObjectInstantiator
{
    /**
     * Instantiate a nagios object
     *
     * @param string      $className
     * @param ArrayReader $fields
     *
     * @return ObjectInterface
     */
    public function instantiate(string $className, ArrayReader $fields): ObjectInterface
    {
        $objectConfigurations = [];
        $namespace = class_basename(ObjectInterface::class);
        $class = $namespace . '\\' . $className;

        $availableObjectConfigurations = (array)call_user_func($class . '::getObjectConfig');
        foreach ($availableObjectConfigurations as $objectConfigurationClass => $objectConfiguration) {
            $fieldConfig = $fields->getArray(class_name($objectConfigurationClass));
            $objectConfigurations[] = new $objectConfigurationClass($fieldConfig['value']);
        }

        $reflection = new ReflectionClass($class);
        $object = $reflection->newInstanceArgs($objectConfigurations);
        if ($object instanceof ObjectInterface) {
            return $object;
        }

        throw new InvalidArgumentException(__('Object cannot be created'));
    }
}
