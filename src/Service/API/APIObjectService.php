<?php

namespace App\Service\API;

use App\Service\Nagios\Objects\ObjectInterface;

/**
 * Class APIObjectService
 */
class APIObjectService
{
    /** @var APIConsumer */
    private $api;

    /**
     * APIObjectService constructor.
     *
     * @param APIConsumer $api
     */
    public function __construct(APIConsumer $api)
    {
        $this->api = $api;
    }

    /**
     * Check if another object can be created
     *
     * @param int $companyId
     * @param int $boxId
     *
     * @return bool
     */
    public function canCreate(int $companyId, int $boxId): bool
    {
        $response = $this->api->get(sprintf('/customers/%s/boxes/%s/quota', $companyId, $boxId));
        $content = $response->getContent();

        return $content->getBool('addition_allowed');
    }
}
