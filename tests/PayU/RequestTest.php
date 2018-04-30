<?php

namespace PayU;

use PHPUnit_Framework_TestCase;

require_once __DIR__ . '/../../vendor/autoload.php';


class RequestTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {

    }

    public function testNothingSet()
    {
        $request = new Request();

        $this->assertEmpty($request->getRequestParams());
    }

    public function testMerchant()
    {
        $merchant = new Merchant('MERCHANT_CODE', 'SECRET');

        $request = new Request();
        $request->setMerchant($merchant);

        $requestParams = $request->getRequestParams();

        $this->assertEquals('MERCHANT_CODE', $requestParams['merchant']);
    }

    public function testCard()
    {
        $card = new Card('number', 'month', 'year', 'name');

        $request = new Request();
        $request->setCard($card);

        $requestParams = $request->getRequestParams();

        $this->assertEquals('number', $requestParams['pan']);
        $this->assertEquals('name', $requestParams['cardholder']);
        $this->assertEquals('month', $requestParams['expiryMonth']);
        $this->assertEquals('year', $requestParams['expiryYear']);
    }

    public function testHashAndDatetime()
    {
        $request = new Request();
        $request->setDatetime("date");
        $request->setSignature("hash");

        $requestParams = $request->getRequestParams();

        $this->assertEquals('hash', $requestParams['signature']);
        $this->assertEquals('date', $requestParams['dateTime']);
    }
}