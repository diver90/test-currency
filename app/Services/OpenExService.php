<?php


namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

class OpenExService
{
    /** @var string */
    public $apiUrl = 'https://openexchangerates.org/api/';

    /** @var string */
    protected $app_id = '1f5a940f625b4cb9956f5bb2df544d58';

    /** @var \GuzzleHttp\Client */
    protected $client;

    const LATEST = 'latest.json';
    const CURRENCIES_LIST = 'currencies.json';

    public function __construct($config = [])
    {
        $this->client = new Client(
            [
                'base_uri' => $this->apiUrl,
                'http_errors'     => false,
            ]
        );
    }

    /**
     * @param string $method
     * @param array $params
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function sendRequest($method, $params = [])
    {
        $params = array_merge($params, ['app_id' => $this->app_id]);
        try {
            $r = $this->client->get(
                $method,
                [
                    'headers' => [
                        'Accept' => 'application/json',
                    ],
                    'curl' => [
                        CURLOPT_SSLVERSION => 6,
                        CURLOPT_RETURNTRANSFER => true
                    ],
                    'query' => $params
                ]
            );
        } catch (\Exception $e) {
            $responceContent = $e->getMessage();
        } finally {
            $responceContent = $responceContent ?? $r->getBody()->getContents();
        }

        return $responceContent;
    }

    public function getLastRates()
    {
        $response = $this->sendRequest(self::LATEST );
        $dataArray = json_decode($response, 1);
        if(array_key_exists('rates', $dataArray)){
            return $dataArray;
        } else{
            throw new \Exception('Wrong data in response');
        }

    }

    public function getCurrenciesList()
    {
        $response = $this->sendRequest(self::CURRENCIES_LIST );
        $dataArray = json_decode($response, 1);
        return $dataArray;
    }
}
