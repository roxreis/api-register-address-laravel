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

    public function getAddressByZipcode(string $zipcode)
    {
        $uri = sprintf('%s/json/', $zipcode);
        $response = $this->client->get($uri);
        return json_decode($response->getBody(), true);
    }
}
