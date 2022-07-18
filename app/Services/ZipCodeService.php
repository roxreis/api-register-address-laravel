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

    public function validateCharacterZipCode($zipcode): bool
    {
        return strlen($zipcode) === 8;
    }


    public function getAddressByZipcode(string $zipcode)
    {
        if (!$this->validateCharacterZipCode($zipcode)) return false;
        $uri = sprintf('%s/json/', $zipcode);
        $response = $this->client->get($uri);
        return json_decode($response->getBody(), true);
    }
}
