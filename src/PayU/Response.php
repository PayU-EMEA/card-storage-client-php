<?php

namespace PayU;

/**
 * Class Response
 * @package PayU
 */
class Response
{

    /** @var string */
    private $token;

    /** @var string */
    private $rawBody;

    /**
     * Response constructor.
     */
    public function __construct()
    {

    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getRawBody()
    {
        return $this->rawBody;
    }

    /**
     * @param $body
     */
    public function setRawBody($body)
    {
        $this->rawBody = $body;
    }
}