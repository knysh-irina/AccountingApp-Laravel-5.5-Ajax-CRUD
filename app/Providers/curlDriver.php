<?php

namespace App\Providers;

class curlDriver {

    private $response;
    private $ch;

    public function setUrl($url) {
        $this->ch = curl_init($url);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
    }

    public function getResponse()
    {
        $this->response = curl_exec($this->ch);
        return $this->response;
    }


}