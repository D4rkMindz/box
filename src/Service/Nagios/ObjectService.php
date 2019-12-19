<?php

namespace App\Service\Nagios;

use App\Service\Nagios\Exception\HostAlreadyExistsException;
use App\Service\Nagios\Exception\HostNotSavedException;
use App\Service\Nagios\Objects\ObjectInterface;
use App\Service\SettingsInterface;
use App\Service\Validation\ObjectValidation;
use App\Util\ArrayReader;
use League\Flysystem\FilesystemInterface;

/**
 * Class HostService
 */
class ObjectService
{
    /** @var NagiosExplorer */
    private $nagiosExplorer;
    /** @var FilesystemInterface */
    private $nagiosFilesystem;
    /** @var ObjectParser */
    private $objectParser;
    /** @var ObjectValidation */
    private $objectValidation;
    /** @var ObjectInstantiator */
    private $instantiator;
    /** @var NagiosTemplateRenderer */
    private $renderer;
    /** @var array */
    private $config;

    /**
     * HostService constructor.
     *
     * @param NagiosExplorer         $nagios
     * @param FilesystemInterface    $filesystem
     * @param ObjectParser           $objectParser
     * @param ObjectValidation       $objectValidation
     * @param ObjectInstantiator     $instantiator
     * @param NagiosTemplateRenderer $renderer
     * @param SettingsInterface      $settings
     */
    public function __construct(
        NagiosExplorer $nagios,
        NagiosFilesystem $filesystem,
        ObjectParser $objectParser,
        ObjectValidation $objectValidation,
        ObjectInstantiator $instantiator,
        NagiosTemplateRenderer $renderer,
        SettingsInterface $settings
    ) {
        $this->nagiosExplorer = $nagios;
        $this->nagiosFilesystem = $filesystem;
        $this->objectParser = $objectParser;
        $this->objectValidation = $objectValidation;
        $this->instantiator = $instantiator;
        $this->renderer = $renderer;
        $this->config = $settings->get(NagiosInterface::class);
    }

    /**
     * Create a nagios object
     *
     * @param string      $class
     * @param int         $companyId
     * @param int         $boxId
     * @param ArrayReader $fields
     *
     * @return ObjectInterface
     */
    public function saveObject(string $class, int $companyId, int $boxId, ArrayReader $fields): ObjectInterface
    {
        $this->objectValidation->validateCreation($class, $companyId, $boxId, $fields);
        $object = $this->instantiator->instantiate($class, $fields);

        $filename = $this->objectParser->parseFilename($object);
        $this->saveObjectToHOSTFile($object, $filename);
        $this->saveObjectToCFGFile($object, $filename);

        return $object;
    }

    /**
     * Save the object config to a .host file
     *
     * @param ObjectInterface $object
     * @param string          $filename
     */
    private function saveObjectToHOSTFile(ObjectInterface $object, string $filename): void
    {
        $json = $this->objectParser->convertObjectToJson($object);

        $savedHost = $this->nagiosExplorer->saveHost($filename, $json);
        if (!$savedHost) {
            throw new HostNotSavedException();
        }
    }

    /**
     * Save object to .cfg file
     *
     * @param ObjectInterface $object
     * @param string          $filename
     */
    private function saveObjectToCFGFile(ObjectInterface $object, string $filename): void
    {
        $template = $this->config['template_root'] . $object->getTemplateName();
        $content = $this->renderer->render($template, $object);
        $path = $this->config['object_root'] . $filename . '.cfg';
        if ($this->nagiosFilesystem->has($path)) {
            // this condition should theoretically never match, because the config is already saved in a host file...
            throw new HostAlreadyExistsException();
        }
        $this->nagiosFilesystem->write($path, $content);
    }
}
