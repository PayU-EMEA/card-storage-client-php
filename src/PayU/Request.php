<?php

namespace PayU;

/**
 * Class Request
 * @package PayU
 */
class Request
{
    /** @var Card */
    private $card = null;

    /** @var Merchant */
    private $merchant = null;

    /** @var array */
    private $parameters = [];

    /**
     * Request constructor.
     */
    public function __construct()
    {

    }

    /**
     * @param Merchant $merchant
     */
    public function setMerchant(Merchant $merchant)
    {
        $this->merchant = $merchant;
    }

    /**
     * @param Card $card
     */
    public function setCard(Card $card)
    {
        $this->card = $card;
    }

    /**
     * @return array
     */
    public function getRequestParams()
    {
        if (null !== $this->card) {
            $this->parameters['pan'] = $this->card->getCardNumber();
            $this->parameters['cardholder'] = $this->card->getOwnerName();
            $this->parameters['expiryMonth'] = $this->card->getExpirationMonth();
            $this->parameters['expiryYear'] = $this->card->getExpirationYear();
        }

        if (null !== $this->merchant) {
            $this->parameters['merchant'] = $this->merchant->getMerchantCode();
        }

        ksort($this->parameters);

        return $this->parameters;
    }

    /**
     * @param string $signature
     */
    public function setSignature($signature)
    {
        $this->parameters['signature'] = $signature;
    }

    /**
     * @param string $datetime
     */
    public function setDatetime($datetime)
    {
        $this->parameters['dateTime'] = $datetime;
    }

}