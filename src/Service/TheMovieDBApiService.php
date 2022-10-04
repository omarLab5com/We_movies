<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class TheMovieDBApiService
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

    public function __construct(string $apiKey, HttpClientInterface $client)
    {
        $this->apiKey = $apiKey;
        $this->client = $client;
    }

    /**
     * Get genres
     * @return array
     */
    public function getGenres(): array
    {
        $res =  $this->getResponse('genre/movie/list');

        return $res['genres'] ?? [];
    }

    /**
     * Get movies
     * ]param array|null genreIds
     * @return array
     */
    public function getMovies(?array $genreIds = []): array
    {
        $res =  $this->getResponse('movie/top_rated');
        $movies = $res['results'] ?? [];

        if ($genreIds) {
            $selectedMovies = [];
            foreach($movies as $movie) {
                if (array_intersect($movie['genre_ids'], $genreIds)) {
                    $selectedMovies[] = $movie;
                }
            }

            return $selectedMovies;
        }

        return $movies;
    }

    /**
     * Get detail movie by id
     * @param int @idMovie
     * @return array
     */
    public function getDetailMovie(int $idMovie): array
    {
        return $this->getResponse('movie/' . $idMovie) ?? [];
    }

    /**
     * Get detail movie by id
     * @param int @idMovie
     * @return array
     */
    public function getVideosMovie(int $idMovie): array
    {
        $res =  $this->getResponse('movie/' . $idMovie . '/videos') ?? [];

        return $res['results'][0] ?? [];
    }

    /**
     * Get response
     * @param string $api
     * @return array
     */
    private function getResponse(string $api): array
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
