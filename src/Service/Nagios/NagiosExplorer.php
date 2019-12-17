<?php

namespace App\Service\Nagios;

use App\Service\Nagios\Exception\TemplateAlreadyExistsException;
use App\Service\Nagios\Objects\ObjectInterface;
use App\Service\SettingsInterface;
use App\Service\UUID\UUID;
use App\Service\Validation\ObjectValidation;
use App\Util\ArrayReader;
use IndieHD\FilenameSanitizer\FilenameSanitizer;
use League\Flysystem\FilesystemInterface;

/**
 * Class ObjectExplorer
 */
class NagiosExplorer
{
    /** @var array */
    private $config;
    /** @var FilesystemInterface */
    private $filesystem;
    /** @var FilesystemInterface */
    private $dataFilesystem;
    /** @var ObjectValidation */
    private $objectValidation;
    /** @var ObjectInstantiator */
    private $instantiator;
    /** @var NagiosTemplateRenderer */
    private $renderer;

    /**
     * NagiosExplorer constructor.
     *
     * @param NagiosFilesystem       $filesystem
     * @param FilesystemInterface    $dataFilesystem
     * @param ObjectValidation       $objectValidation
     * @param ObjectInstantiator     $instantiator
     * @param NagiosTemplateRenderer $renderer
     * @param SettingsInterface      $settings
     */
    public function __construct(
        NagiosFilesystem $filesystem,
        FilesystemInterface $dataFilesystem,
        ObjectValidation $objectValidation,
        ObjectInstantiator $instantiator,
        NagiosTemplateRenderer $renderer,
        SettingsInterface $settings
    ) {
        $this->config = $settings->get(NagiosInterface::class);
        $this->filesystem = $filesystem;
        $this->objectValidation = $objectValidation;
        $this->instantiator = $instantiator;
        $this->renderer = $renderer;
        $this->dataFilesystem = $dataFilesystem;
    }

    /**
     * Create a template
     *
     * @param string $name    The name of the object template to create (e.g. Mailserver)
     * @param string $content The content of the template file
     *
     * @return bool Indicates if the file was created
     */
    public function createTemplate(string $name, string $content = ''): bool
    {
        $templateName = $this->config['template_root'] . $this->sanitizeFilename($name) . '.template';
        if ($this->dataFilesystem->has($templateName)) {
            throw new TemplateAlreadyExistsException();
        }

        return $this->filesystem->put($templateName, $content);
    }

    /**
     * Get all templates
     *
     * @return ObjectInterface[]
     */
    public function listTemplates(): array
    {
        return require __DIR__ . '/../../../config/templates.php';
    }

    /**
     * Sanitize a filename
     *
     * @param string $filename The filename that should be sanitized
     *
     * @return string
     */
    private function sanitizeFilename(string $filename): string
    {
        $filenameSanitizer = new FilenameSanitizer($filename);

        return $filenameSanitizer->stripPhp()
            ->stripRiskyCharacters()
            ->stripIllegalFilesystemCharacters()
            ->getFilename();
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
    public function createObject(string $class, int $companyId, int $boxId, ArrayReader $fields): ObjectInterface
    {
        $this->objectValidation->validateCreation($class, $companyId, $boxId, $fields);
        $object = $this->instantiator->instantiate($class, $fields);

        $template = $this->config['template_root'] . $object->getTemplateName();
        $content = $this->renderer->render($template, $object);
        $path = $this->config['object_root'] . UUID::generate() . '.cfg';
        $this->filesystem->write($path, $content);

        return $object;
    }
}
