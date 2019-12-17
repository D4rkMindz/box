<?php

namespace App\Controller\API;

use App\Exception\ValidationException;
use App\Service\Encoder\JSONEncoder;
use App\Service\Nagios\NagiosExplorer;
use App\Type\SessionKey;
use App\Util\ArrayReader;
use App\Util\ValidationResult;
use Firebase\JWT\JWT;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use PSR7Sessions\Storageless\Http\SessionMiddleware;
use PSR7Sessions\Storageless\Session\SessionInterface;

/**
 * Class ObjectController
 */
class ObjectController
{
    /** @var JSONEncoder */
    private $json;
    /** @var LoggerInterface */
    private $logger;
    /** @var NagiosExplorer */
    private $nagios;

    /**
     * ObjectController constructor.
     *
     * @param JSONEncoder     $json
     * @param LoggerInterface $logger
     * @param NagiosExplorer  $nagiosExplorer
     */
    public function __construct(JSONEncoder $json, LoggerInterface $logger, NagiosExplorer $nagiosExplorer)
    {
        $this->json = $json;
        $this->logger = $logger;
        $this->nagios = $nagiosExplorer;
    }


    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     *
     * @return ResponseInterface
     */
    public function createObjectAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            $data = new ArrayReader($request->getParsedBody());
            $class = $data->getString('class');
            $fields = new ArrayReader($data->getArray('fields'));
        } catch (InvalidArgumentException $exception) {
            $validationResult = new ValidationResult(__('Please check your data'));
            $validationResult->setError('form', __('Please ensure that all required fields are filled in'));
            throw new ValidationException($validationResult);
        }

        /** @var SessionInterface $session */
        $session = $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);
        $token = $session->get(SessionKey::JWT_DECODED);
        $boxId = 1;
        $companyId = $token['payload']['data']['company_id'];

        $this->nagios->createObject($class, $companyId, $boxId, $fields);

        return $this->json->encode($response, ['success' => true]);
    }
}
