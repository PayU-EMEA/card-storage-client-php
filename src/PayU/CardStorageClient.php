<?php

namespace PayU;

use PayU\Exceptions\ConnectionException;
use PayU\Exceptions\InvalidResponseException;

/**
 * Class CardStorageClient
 * @package PayU
 */
class CardStorageClient
{

    /** @var HttpClient */
    private $httpClient;

    /** @var ParametersSignatureCalculator */
    private $signatureCalculator;

    /** @var Request */
    private $request;

    /** @var DateTimeProvider */
    private $dateTimeProvider;

    /** @var Response */
    private $responseBuilder;

    /**
     * CardStorageClient constructor.
     * @param HttpClient $httpClient
     * @param ParametersSignatureCalculator $signatureCalculator
     * @param Request $request
     * @param DateTimeProvider $dateTimeProvider
     * @param ResponseBuilder $responseBuilder
     */
    public function __construct(HttpClient $httpClient, ParametersSignatureCalculator $signatureCalculator, Request $request, DateTimeProvider $dateTimeProvider, ResponseBuilder $responseBuilder)
    {
        $this->httpClient = $httpClient;
        $this->signatureCalculator = $signatureCalculator;
        $this->request = $request;
        $this->dateTimeProvider = $dateTimeProvider;
        $this->responseBuilder = $responseBuilder;
    }

    /**
     * @param Merchant $merchant
     * @param Card $card
     * @param string $url
     * @return Response
     * @throws ConnectionException
     * @throws InvalidResponseException
     */
    public function storeCard(Merchant $merchant, Card $card, $url)
    {
        $this->request->setMerchant($merchant);
        $this->request->setCard($card);
        $this->request->setDatetime($this->dateTimeProvider->getDatetime());

        $signature = $this->signatureCalculator->calculateSignature(
            ParametersSignatureCalculator::HASHING_ALGORITHM_SHA256,
            $merchant->getSecretKey(),
            $this->request->getRequestParams()
        );
        $this->request->setSignature($signature);

        return $this->getResponse($url, $this->request->getRequestParams());
    }

    /**
     * @param $url
     * @param $postParams
     * @return Response
     * @throws ConnectionException
     * @throws InvalidResponseException
     */
    private function getResponse($url, $postParams)
    {
        try {
            $this->httpClient->skipSSLVerifyPeer();
            $response = $this->httpClient->post($url, $postParams);
        } catch (ConnectionException $exception) {
            throw $exception;
        }

        return $this->responseBuilder->build($response);
    }
}