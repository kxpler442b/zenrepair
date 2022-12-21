<?php

namespace App;

class Pocketbase
{
    public function __construct()
    {
        $this->config = PB_CONFIG;
    }

    public function __destruct() {}

    private function buildURL(string $query): string
    {
        $url = 'http://' . $this->config['server_ip'] . ':' . $this->config['server_port'] . $query;

        return $url;
    }

    public function getFromAPI($query)
    {
        $url = $this->buildURL($query);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($curl);
        curl_close($curl);

        $result = json_decode($response);

        return $result;
    }

    public function postToAPI($url, $authorisation)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    }
}