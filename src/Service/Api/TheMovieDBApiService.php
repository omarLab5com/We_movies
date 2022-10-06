<?php

namespace App\Service\Api;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class TheMovieDBApiService
{
    /**
     * @var HttpClientInterface
     */
    private $client;

    /**
     * @var TheMovieDBApiInterface
     */
    private $theMovieDBApi;

    public function __construct(HttpClientInterface $client, TheMovieDBApiInterface $theMovieDBApi)
    {
        $this->client = $client;
        $this->theMovieDBApi = $theMovieDBApi;
    }

    /**
     * Get genres
     * @return array
     */
    public function getGenres(): array
    {
        $res =  $this->theMovieDBApi->getData('genre/movie/list');

        return $res['genres'] ?? [];
    }

    /**
     * Get movies
     * ]param array|null genreIds
     * @return array
     */
    public function getMovies(?array $genreIds = []): array
    {
        $res =  $this->theMovieDBApi->getData('movie/top_rated');
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
        return $this->theMovieDBApi->getData('movie/' . $idMovie) ?? [];
    }

    /**
     * Get detail movie by id
     * @param int @idMovie
     * @return array
     */
    public function getVideosMovie(int $idMovie): array
    {
        $res =  $this->theMovieDBApi->getData('movie/' . $idMovie . '/videos') ?? [];

        return $res['results'][0] ?? [];
    }
}
