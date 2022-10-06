<?php

namespace App\Service\Api;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class TheMovieDBApi implements TheMovieDBApiInterface
{
    const API_URL = 'https://api.themoviedb.org/3/';

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var HttpClientInterface
     */
    private $client;

    /**
     * Construct TheMovieDBApi.
     *
     * @param string $apiKey
     * @param HttpClientInterface $client
     */
    public function __construct(string $apiKey, HttpClientInterface $client)
    {
        $this->apiKey = $apiKey;
        $this->client = $client;
    }

    /**
     * Get data
     * @param string $api
     * @return array
     */
    public function getData(string $api): array
    {
        try {
            $response = $this->client->request(
                'GET',
                $this->getUrl($api)
            );

            if ($response->getStatusCode() != 200) {
                return [];
            }

            return $response->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Get url
     * @param string $api
     * @return string
     */
    private function getUrl(string $api): string
    {
        return self::API_URL . $api . '?api_key=' . $this->apiKey . '&language=fr-FR';
    }
}