<?php

namespace App\Providers;


class PrivatBankDataProvider
{
    private $handler;

    public function __construct()
    {
        $this->handler = new curlDriver();
    }


    public function getCurrencyRate()
    {

        $this->handler->setUrl("https://api.privatbank.ua/p24api/pubinfo?json&exchange&coursid=5");
        $response = $this->handler->getResponse();
        $data_usd = json_decode($response)[2];
        $carrency_rate = ($data_usd->buy + $data_usd->sale) / 2 ;
        return $carrency_rate;
    }

}