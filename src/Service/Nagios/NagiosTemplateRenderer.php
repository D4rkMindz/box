<?php

namespace App\Service\Nagios;

use App\Service\Nagios\Objects\ObjectInterface;
use League\Flysystem\FilesystemInterface;

/**
 * Class NagiosTemplateRenderer
 */
class NagiosTemplateRenderer
{
    /** @var FilesystemInterface */
    private $filesystem;

    /**
     * NagiosTemplateRenderer constructor.
     *
     * @param FilesystemInterface $filesystem
     */
    public function __construct(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Render a
     *
     * @param string          $templateFile
     * @param ObjectInterface $object
     *
     * @return string
     */
    public function render(string $templateFile, ObjectInterface $object): string
    {
        $content = $this->filesystem->read($templateFile);
        $config = $object->getConfig();
        foreach ($config as $configObject) {
            $variableName = $configObject::getTemplateVariableName();
            $content = str_replace(sprintf('{{ %s }}', $variableName), $configObject->getValue(), $content);
        }

        return $content;
    }
}
