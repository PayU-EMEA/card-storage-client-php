<?php

namespace PayU;

use PHPUnit_Framework_TestCase;

require_once __DIR__ . '/../../vendor/autoload.php';


class CardStorageClientTest extends PHPUnit_Framework_TestCase
{

    /** @var Request */
    private $requestMock;

    /** @var ParametersSignatureCalculator */
    private $signatureCalculatorMock;

    /** @var HttpClient */
    private $httpClientMock;

    /** @var DateTimeProvider */
    private $datetimeProviderMock;

    /** @var CardStorageClient */
    private $cardStorageClient;

    /** @var ResponseBuilder */
    private $responseBuilderMock;

    private $successResponseBody = '{"token":"3b41600f-ab58-4e0c-922e-64d2dd0a73d5"}';

    public function setUp()
    {

        $this->signatureCalculatorMock = $this->createMock(ParametersSignatureCalculator::class);
        $this->signatureCalculatorMock->method('calculateSignature')->willReturn('CALCULATED_SIGNATURE');

        $this->datetimeProviderMock = $this->createMock(DateTimeProvider::class);
        $this->datetimeProviderMock->method('getDatetime')->willReturn('999999');

        $this->responseBuilderMock = $this->createMock(ResponseBuilder::class);
        $this->responseBuilderMock->method('build')->willReturn($this->getResponseObject());

        $this->requestMock = $this->createMock(Request::class);
        $this->requestMock->method('getRequestParams')->willReturn([]);

        $this->httpClientMock = $this->createMock(HttpClient::class);
        $this->httpClientMock->method('post')->willReturn($this->successResponseBody);

        $this->cardStorageClient = new CardStorageClient(
            $this->httpClientMock,
            $this->signatureCalculatorMock,
            $this->requestMock,
            $this->datetimeProviderMock,
            $this->responseBuilderMock
        );
    }

    public function testStoreCard() {

        $response = $this->cardStorageClient->storeCard(
            new Merchant('DUMMY_MERC_CODE', 'DUMMY_SECRET_KEY'),
            new Card('4111111111111111', '12', '2019', '123', 'Owner'),
            'http://TEST_URL'
        );

        $this->assertEquals($response, $this->getResponseObject());
    }

    /**
     * @return Response
     */
    private function getResponseObject() {
        return (new ResponseBuilder())->build($this->successResponseBody);
    }
}