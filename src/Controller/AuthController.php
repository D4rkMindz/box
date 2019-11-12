<?php

namespace App\Controller;

use App\Service\Encoder\HTMLEncoder;
use App\Service\Encoder\RedirectEncoder;
use App\Type\SessionKey;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use PSR7Sessions\Storageless\Http\SessionMiddleware;

/**
 * Class AuthController
 */
class AuthController
{
    /** @var HTMLEncoder */
    private $encoder;
    /** @var LoggerInterface */
    private $logger;
    /** @var RedirectEncoder */
    private $redirect;

    /**
     * IndexController constructor.
     *
     * @param HTMLEncoder              $encoder
     * @param RedirectEncoder          $redirect
     * @param LoggerInterface          $logger
     */
    public function __construct(
        HTMLEncoder $encoder,
        RedirectEncoder $redirect,
        LoggerInterface $logger
    ) {
        $this->encoder = $encoder;
        $this->redirect = $redirect;
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
        return $this->encoder->encode($request, $response, 'Auth/index.html.twig');
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     *
     * @return ResponseInterface
     */
    public function loginAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $session = $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);
        $session->set(SessionKey::AUTHENTICATED, true);
        return $this->redirect->encode($response, '/admin');
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     *
     * @return ResponseInterface
     */
    public function logoutAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $session = $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);
        $session->remove(SessionKey::AUTHENTICATED);
        return $this->redirect->encode($response, '/login');
    }
}
