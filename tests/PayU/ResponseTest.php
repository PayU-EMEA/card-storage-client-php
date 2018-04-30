<?php

namespace PayU;

use PHPUnit_Framework_TestCase;

require_once __DIR__ . '/../../vendor/autoload.php';


class ResponseTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {

    }

    public function testSuccess()
    {
        $rawBody = '{"token":"3b41600f-ab58-4e0c-922e-64d2dd0a73d5"}';
        $json = json_decode($rawBody, true);
        $response = new Response();
        $response->setRawBody($rawBody);
        $response->setToken($json['token']);

        $this->assertEquals($rawBody, $response->getRawBody());
        $this->assertEquals($json['token'], $response->getToken());
    }
}