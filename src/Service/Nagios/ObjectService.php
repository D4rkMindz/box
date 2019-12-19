<?php

namespace App\Service\Nagios;

use App\Service\Nagios\Objects\ObjectInterface;
use App\Util\ArrayReader;
use League\Flysystem\FilesystemInterface;

/**
 * Class HostService
 */
class HostService
{
    /** @var NagiosExplorer */
    private $nagios;
    /** @var FilesystemInterface */
    private $filesystem;
    /** @var ObjectParser */
    private $objectParser;

    /**
     * HostService constructor.
     *
     * @param NagiosExplorer      $nagios
     * @param FilesystemInterface $filesystem
     */
    public function __construct(NagiosExplorer $nagios, FilesystemInterface $filesystem, ObjectParser $objectParser)
    {
        $this->nagios = $nagios;
        $this->filesystem = $filesystem;
        $this->objectParser = $objectParser;
    }

    /**
     * Create an object
     *
     * @param ObjectInterface $object
     */
    public function createObject(ObjectInterface $object)
    {
        $json = $this->objectParser->convertObjectToJson($object);
        $filename = $this->objectParser->parseFilename($object);

        $this->nagios->createHost($filename, $json);


    }

    /**
     * Create a nagios object
     *
     * @param string      $name
     * @param string      $class
     * @param int         $companyId
     * @param int         $boxId
     * @param ArrayReader $fields
     *
     * @return ObjectInterface
     */
    public function saveObject(
        string $name,
        string $class,
        int $companyId,
        int $boxId,
        ArrayReader $fields
    ): ObjectInterface {
        $this->objectValidation->validateCreation($class, $companyId, $boxId, $fields);
        $object = $this->instantiator->instantiate($class, $fields);

        $template = $this->config['template_root'] . $object->getTemplateName();
        $content = $this->renderer->render($template, $object);
        $path = $this->config['object_root'] . $name . '.cfg';
        $this->filesystem->write($path, $content);

        return $object;
    }
}
