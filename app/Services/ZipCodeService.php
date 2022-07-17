<?php
namespace App\Services;

use GuzzleHttp\Client;

class ZipCodeService
{
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://viacep.com.br/ws/',
            'time_out' => 5.0,
            'verify' => false
        ]);
    }

    public function mascForZipCode($zipcode)
    {
        // return masc 00000000
        return preg_replace("/[^0-9]/", "", $zipcode);
    }

    public function getAddressByZipcode(string $zipcode)
    {
        $uri = sprintf('%s/json/', $this->mascForZipCode($zipcode));
        $response = $this->client->get($uri);
        return json_decode($response->getBody(), true);
    }
}
