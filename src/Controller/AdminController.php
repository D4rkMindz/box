<?php

namespace App\Controller;

use App\Service\Encoder\HTMLEncoder;
use App\Service\Nagios\NagiosExplorer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class AdminController
 */
class AdminController
{
    /** @var HTMLEncoder */
    private $encoder;
    /** @var NagiosExplorer */
    private $nagiosExplorer;

    /**
     * AdminController constructor.
     *
     * @param HTMLEncoder $encoder
     */
    public function __construct(HTMLEncoder $encoder, NagiosExplorer $nagiosExplorer)
    {
        $this->encoder = $encoder;
        $this->nagiosExplorer = $nagiosExplorer;
    }

    public function indexAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $templates = $this->nagiosExplorer->listTemplates();
        //TODO: Read .host file from data/hosts
        $data = [
            'hosts' => [
                [
                    'name' => 'Server 1',
                    'img' => 'https://cdn.pixabay.com/photo/2013/07/13/10/17/computer-156948__340.png',
                ],
                [
                    'name' => 'Server 3',
                    'img' => 'https://cdn.pixabay.com/photo/2013/07/13/10/17/computer-156948__340.png',
                ],
                [
                    'name' => 'Server 2',
                    'img' => 'https://cdn.pixabay.com/photo/2013/07/13/10/17/computer-156948__340.png',
                ],
                ['name' => 'Mail', 'img' => 'https://cdn.pixabay.com/photo/2013/07/13/10/17/computer-156948__340.png'],
                [
                    'name' => 'Mail 2',
                    'img' => 'https://cdn.pixabay.com/photo/2013/07/13/10/17/computer-156948__340.png',
                ],
                [
                    'name' => 'Mail 4',
                    'img' => 'https://cdn.pixabay.com/photo/2013/07/13/10/17/computer-156948__340.png',
                ],
                [
                    'name' => 'Uplink',
                    'img' => 'https://cdn.pixabay.com/photo/2013/07/13/10/17/computer-156948__340.png',
                ],
            ],
            'templates' => json_encode($templates),
        ];

        return $this->encoder->encode($request, $response, 'Admin/index.html.twig', $data);
    }
}
