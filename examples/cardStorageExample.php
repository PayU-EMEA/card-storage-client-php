<?php

require_once __DIR__ . '/testData/TestData.php';
require_once __DIR__ . '/../src/init.php';

use PayU\Card;
use PayU\CardStorageClient;
use PayU\DateTimeProvider;
use PayU\HttpClient;
use PayU\Merchant;
use PayU\ParametersSignatureCalculator;
use PayU\Request;
use PayU\ResponseBuilder;

// instantiate Merchant
$merchant = new Merchant(
    TestData::MERCHANT_CODE,
    TestData::MERCHANT_SECRET_KEY
);

// instantiate Card
$card = new Card(
    TestData::CARD_NUMBER,
    TestData::CARD_EXP_MONTH,
    TestData::CARD_EXP_YEAR,
    TestData::CARD_OWNER_NAME
);

try {
    // instantiate CardStorageClient
    $cardStorageClient = new CardStorageClient(
        new HttpClient(),
        new ParametersSignatureCalculator(),
        new Request(),
        new DateTimeProvider(),
        new ResponseBuilder()
    );

    $response = $cardStorageClient->storeCard(
        $merchant,
        $card,
        TestData::CARD_STORAGE_API_URL
    );

    echo "<b>Card storage (success)</b>: <br/>";
    echo "======================================================= <br/>";
    echo $response->getToken() . "<br/><br/>";

    echo "</b><b>Response raw body</b>: <br/>";
    echo "======================================================= <br/>";
    echo $response->getRawBody();

} catch(Exception $e) {
    /**
     * ConnectionException
     * InvalidResponseException
     */
    echo "<b>There was an exception while storing card</b>: <br/>";
    echo "======================================================= <br/>";
    echo $e->getMessage();
}

