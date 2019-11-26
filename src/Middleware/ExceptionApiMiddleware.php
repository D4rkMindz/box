<?php

namespace App\Middleware;

use App\Exception\AuthenticationException;
use App\Exception\RecordNotFoundException;
use App\Exception\ValidationException;
use App\Service\Encoder\JSONEncoder;
use App\Type\HttpCode;
use Exception;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class ExceptionApiMiddleware
 */
class ExceptionApiMiddleware implements MiddlewareInterface
{
    /** @var JSONEncoder */
    private $encoder;
    /** @var ResponseFactoryInterface */
    private $responseFactory;

    /**
     * ExceptionMiddleware constructor.
     *
     * @param JSONEncoder              $encoder
     * @param ResponseFactoryInterface $responseFactory
     */
    public function __construct(JSONEncoder $encoder, ResponseFactoryInterface $responseFactory)
    {
        $this->encoder = $encoder;
        $this->responseFactory = $responseFactory;
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
        try {
            return $handler->handle($request);
        } catch (ValidationException $exception) {
            return $this->handleValidationException($exception);
        } catch (RecordNotFoundException $exception) {
            return $this->handleRecordNotFoundException($exception);
        } catch (AuthenticationException $exception) {
            return $this->handleAuthenticationException($exception);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }
    }

    /**
     * Handle validation exception.
     *
     * @param ValidationException $exception
     *
     * @return ResponseInterface
     */
    private function handleValidationException(ValidationException $exception): ResponseInterface
    {
        $validationResult = $exception->getValidationResult();
        $data = [
            'status' => HttpCode::UNPROCESSABLE_ENTITY,
            'message' => $validationResult->getMessage(),
            'errors' => $validationResult->getErrors(),
            'success' => false,
        ];

        return $this->sendMetaData($data, HttpCode::UNPROCESSABLE_ENTITY);
    }

    /**
     * Handle a record not found exception
     *
     * @param RecordNotFoundException $exception
     *
     * @return ResponseInterface
     */
    private function handleRecordNotFoundException(RecordNotFoundException $exception): ResponseInterface
    {
        $message = $exception->getMessage();

        $data = [
            'status' => HttpCode::NOT_FOUND,
            'message' => $message,
            'success' => false,
        ];

        return $this->sendMetaData($data, HttpCode::NOT_FOUND);
    }

    /**
     * Handle authentication exception
     *
     * @param AuthenticationException $exception
     *
     * @return ResponseInterface
     */
    public function handleAuthenticationException(AuthenticationException $exception): ResponseInterface
    {
        $data = [
            'status' => $exception->getStatusCode() ?: HttpCode::UNAUTHORIZED,
            'message' => $exception->getMessage() ?: __('Authentication failed'),
            'success' => false,
        ];

        return $this->sendMetaData($data, $data['status']);
    }

    /**
     * Handle exception.
     *
     * @param Exception $exception
     *
     * @return ResponseInterface
     */
    protected function handleException(Exception $exception): ResponseInterface
    {
        $message = $exception->getMessage();

        $data = [
            'status' => HttpCode::BAD_REQUEST,
            'message' => $message,
            'success' => false,
        ];

        return $this->sendMetaData($data, HttpCode::BAD_REQUEST);
    }


    /**
     * Add the required meta data
     *
     * @param array $data   The data
     * @param int   $status The status
     *
     * @return ResponseInterface
     */
    private function sendMetaData(array $data, int $status)
    {
        $response = $this->responseFactory->createResponse($status);
        $data['success'] = isset($data['success']) ? $data['success'] : $status === 200;
        $data['status'] = $response->getStatusCode();

        return $this->encoder->encode($response, $data);
    }
}
