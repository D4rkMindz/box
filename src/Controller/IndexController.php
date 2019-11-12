<?php

namespace App\Controller;

use App\Service\Encoder\HTMLEncoder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

/**
 * Class IndexController
 */
class IndexController
{
    /** @var HTMLEncoder */
    private $encoder;
    /** @var LoggerInterface */
    private $logger;

    /**
     * IndexController constructor.
     *
     * @param HTMLEncoder     $encoder
     * @param LoggerInterface $logger
     */
    public function __construct(
        HTMLEncoder $encoder,
        LoggerInterface $logger
    ) {
        $this->encoder = $encoder;
        $this->logger = $logger;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     *
     * @return ResponseInterface
     */
    public function indexAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
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
                ['name' => 'Mail 2', 'img' => 'https://cdn.pixabay.com/photo/2013/07/13/10/17/computer-156948__340.png'],
                ['name' => 'Mail 4', 'img' => 'https://cdn.pixabay.com/photo/2013/07/13/10/17/computer-156948__340.png'],
                [
                    'name' => 'Uplink',
                    'img' => 'https://cdn.pixabay.com/photo/2013/07/13/10/17/computer-156948__340.png',
                ],
            ],
        ];

        $count = round(count($data['hosts']) / 2);

        $data['col_count'] = $count;

        return $this->encoder->encode($request, $response, 'Index/index.html.twig', $data);
    }
}
