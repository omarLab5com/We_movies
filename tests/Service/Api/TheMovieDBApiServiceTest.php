<?php

namespace App\Tests\Api;

use App\Service\Api\TheMovieDBApiService;
use App\Service\Api\TheMovieDBApi;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TheMovieDBApiServiceTest extends TestCase
{
    private TheMovieDBApiService $theMovieDBApiService;
    private TheMovieDBApi $theMovieDBApi;

    public function setUp(): void
    {
        $httpClientInterface = $this->createMock(HttpClientInterface::class);
        $this->theMovieDBApi = $this->createMock(TheMovieDBApi::class);
        $this->theMovieDBApiService = new TheMovieDBApiService($httpClientInterface, $this->theMovieDBApi);
    }

    public function testGetGenres(): void
    {
        $genres = [
            ['id' => 1, 'name' => 'Action'],
            ['id' => 2, 'name' => 'Aventure']
        ];
        $this->theMovieDBApi->expects($this->once())
            ->method('getData')
            ->willReturn(['genres' => $genres]);

        $data = $this->theMovieDBApiService->getGenres();

        $this->assertEquals($genres, $data);
    }

    public function testGetMoviesWithoutFilter(): void
    {
        $movies = $this->getMoviesData();
        $this->theMovieDBApi->expects($this->once())
            ->method('getData')
            ->willReturn(['results' => $movies]);

        $data = $this->theMovieDBApiService->getMovies();

        $this->assertEquals($movies, $data);
    }

    public function testGetMoviesWitFilter(): void
    {
        $genreIds = [1, 2];
        $movies = $this->getMoviesData();
        $this->theMovieDBApi->expects($this->once())
            ->method('getData')
            ->willReturn(['results' => $movies]);

        $data = $this->theMovieDBApiService->getMovies($genreIds);
        $selectedMovies = array_slice($movies, 0, 3);

        $this->assertEquals($selectedMovies, $data);
    }

    public function testGetDetailMovie(): void
    {
        $movie = $this->getMoviesData()[0];
        $this->theMovieDBApi->expects($this->once())
            ->method('getData')
            ->willReturn($movie);

        $data = $this->theMovieDBApiService->getDetailMovie(1);

        $this->assertEquals($movie, $data);
    }

    public function testGetVideosMovie(): void
    {
        $video = ['id' => '5b5ae13ec3a368670400db09', 'site' => 'YouTube', 'name' => 'Video 1', 'key' => 'ktCk487JeMw'];
        $this->theMovieDBApi->expects($this->once())
            ->method('getData')
            ->willReturn(['id' => 2, 'results' => [$video]]);

        $data = $this->theMovieDBApiService->getVideosMovie(2);

        $this->assertEquals($video, $data);
    }

    private function getMoviesData(): array
    {
        return [
            ['id' => 1, 'genre_ids' => [1], 'title' => 'Movie 1', 'release_date' => '2020-05-18'],
            ['id' => 2, 'genre_ids' => [2], 'title' => 'Movie 2', 'release_date' => '1972-03-14'],
            ['id' => 3, 'genre_ids' => [1, 2], 'title' => 'Movie 3', 'release_date' => '2016-01-27'],
            ['id' => 4, 'genre_ids' => [3], 'title' => 'Movie 4', 'release_date' => '2001-10-02'],
        ];
    }
}