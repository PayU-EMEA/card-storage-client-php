<?php

namespace PayU;

use PayU\Exceptions\InvalidResponseException;

/**
 * Class ResponseBuilder
 * @package PayU
 */
class ResponseBuilder
{

    /**
     * ResponseBuilder constructor.
     */
    public function __construct()
    {
        
    }

    /**
     * @param string $responseBody
     * @return Response
     * @throws InvalidResponseException
     */
    public function build($responseBody)
    {
        $formatted = json_decode($responseBody, true);

        if (is_null($formatted)) {
            throw new InvalidResponseException("Can't decode response");
        }

        if (!isset($formatted['token'])) {
            throw new InvalidResponseException("Incomplete response");
        }

        $response = new Response();
        $response->setRawBody($responseBody);
        $response->setToken($formatted['token']);

        return $response;
    }
}