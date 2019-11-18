<?php

namespace App\Service\Nagios;

use App\Service\Nagios\Exception\TemplateAlreadyExistsException;
use App\Service\Nagios\Objects\ObjectInterface;
use App\Service\SettingsInterface;
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

    /**
     * NagiosExplorer constructor.
     *
     * @param NagiosFilesystem    $filesystem
     * @param FilesystemInterface $dataFilesystem
     * @param SettingsInterface   $settings
     */
    public function __construct(
        NagiosFilesystem $filesystem,
        FilesystemInterface $dataFilesystem,
        SettingsInterface $settings
    ) {
        $this->config = $settings->get(NagiosInterface::class);
        $this->filesystem = $filesystem;
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
        $templateName = $this->config['template_root'] . $this->sanitizeFilename($name) . '.cfg';
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
}
