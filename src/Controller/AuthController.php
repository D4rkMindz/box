<?php

namespace App\Controller;

use App\Exception\AuthenticationException;
use App\Service\Auth\AuthService;
use App\Service\Encoder\HTMLEncoder;
use App\Service\Encoder\RedirectEncoder;
use App\Type\SessionKey;
use App\Util\ArrayReader;
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
    /** @var AuthService */
    private $auth;

    /**
     * IndexController constructor.
     *
     * @param AuthService     $auth
     * @param HTMLEncoder     $encoder
     * @param RedirectEncoder $redirect
     * @param LoggerInterface $logger
     */
    public function __construct(
        AuthService $auth,
        HTMLEncoder $encoder,
        RedirectEncoder $redirect,
        LoggerInterface $logger
    ) {
        $this->auth = $auth;
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
        $data = new ArrayReader($request->getParsedBody());
        $username = $data->findString('username');
        $password = $data->findString('password');

        try {
            $tokens = $this->auth->login($username, $password);
        } catch (AuthenticationException $exception) {
            $this->logger->info('Authentication failed for ' . $username . '  because of an invalid username');

            return $this->encoder->encode(
                $request,
                $response,
                'Auth/index.html.twig',
                ['error' => $exception->getMessage()]
            );
        }

        $session = $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);
        $session->set(SessionKey::AUTHENTICATED, true);
        $session->set(SessionKey::JWT, $tokens['token']);
        $session->set(SessionKey::REFRESH_TOKEN, $tokens['refresh']);
        [$header, $payload, $signature] = explode('.', $tokens['token']);
        $decoded = [
            'header' => json_decode(base64_decode($header, true)),
            'payload' => json_decode(base64_decode($payload), true),
        ];
        $session->set(SessionKey::JWT_DECODED, $decoded);

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
