<?php

namespace App\Middleware;

use App\Service\Encoder\JSONEncoder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Routing\RouteContext;
use Symfony\Component\Translation\Translator;

/**
 * Class LanguageMiddleware.
 */
class LanguageMiddleware implements MiddlewareInterface
{
    /** @var Translator */
    private $translator;
    /** @var array */
    private $whitelist;
    /** @var JSONEncoder */
    private $encoder;

    /**
     * LanguageMiddleware constructor.
     *
     * @param Translator  $translator
     * @param JSONEncoder $encoder
     */
    public function __construct(Translator $translator, JSONEncoder $encoder)
    {
        $this->translator = $translator;
        $this->encoder = $encoder;
        $this->whitelist = [
            'de' => 'de_CH',
            'de_CH' => 'de_CH',
            'en' => 'en_GB',
            'en_GB' => 'en_GB',
            'default' => 'en_GB',
        ];
    }

    /**
     * The called method.
     *
     * This method will be invoked if a middleware is executed
     *
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $route = RouteContext::fromRequest($request)->getRoute();
        if (empty($route)) {
            return $handler->handle($request);
        }

        $language = $this->extractLanguage($request);
        $parsed = $this->parseLanguage($language);

        $this->setLocale($parsed);

        $request = $request->withAttribute('language', $parsed);
        $response = $handler->handle($request);
        $response = $response->withAddedHeader('Venovum-Language', $parsed);
        $contentType = $response->getHeader('Content-Type');
        if (!empty($contentType) && $contentType[0] === 'application/json') {
            $json = $response->getBody();
            $data = json_decode($json, true);
            $data['language'] = $parsed;
            $response = $this->encoder->encode($response, $data);
        }

        return $response;
    }

    /**
     * Extract the language.
     *
     * @param ServerRequestInterface $request
     *
     * @return string
     */
    protected function extractLanguage(ServerRequestInterface $request): string
    {
        $language = null;
        if (empty($language)) {
            $language = array_value('lang', $request->getQueryParams());
        }
        if (empty($language)) {
            $language = 'en_GB';
        }

        return $language;
    }

    /**
     * Verify if the language is allowed.
     *
     * @param string $language
     *
     * @return string The parsed language
     */
    protected function parseLanguage(
        string $language
    ): string {
        if (!isset($this->whitelist[$language])) {
            return $this->whitelist['default'];
        }

        return $this->whitelist[$language];
    }

    /**
     * Set the locale.
     *
     * @param string $language
     */
    protected function setLocale(string $language): void
    {
        $locale = $this->whitelist[$language];

        $resource = __DIR__ . '/../resources/locale/' . $locale . '_messages.mo';
        $this->translator->setLocale($locale);
        $this->translator->setFallbackLocales(['en_US']);
        $this->translator->addResource('mo', $resource, $locale);
    }
}
