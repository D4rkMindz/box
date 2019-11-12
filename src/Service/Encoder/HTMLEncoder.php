<?php

namespace App\Service\Encoder;

use App\Type\SessionKey;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use PSR7Sessions\Storageless\Http\SessionMiddleware;
use PSR7Sessions\Storageless\Session\LazySession;
use Slim\Views\Twig;

/**
 * Class HTMLEncoder
 */
class HTMLEncoder
{
    /** @var Twig */
    private $twig;

    /**
     * HTMLEncoder constructor.
     *
     * @param Twig $twig
     */
    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Encode a response.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param string                 $template
     * @param array                  $data
     *
     * @return ResponseInterface
     */
    public function encode(
        ServerRequestInterface $request,
        ResponseInterface $response,
        string $template,
        array $data = []
    ): ResponseInterface {
        /** @var LazySession $session */
        $session = $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);
        $data['authenticated'] = (bool)$session->get(SessionKey::AUTHENTICATED);

        return $this->twig->render($response, $template, $data)->withAddedHeader('Content-Type', 'text/html');
    }
}
