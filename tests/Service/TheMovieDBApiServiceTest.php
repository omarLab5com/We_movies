<?php

namespace App\Tests\Service;

use App\Service\TheMovieDBApiService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TheMovieDBApiServiceTest extends KernelTestCase
{
    private TheMovieDBApiService $theMovieDBApiService;

    public function testGetGenres(): void
    {
        $theMovieDBApiService = $this->getService();
        $genres = $theMovieDBApiService->getGenres();
        $this->assertAction($genres, ['id', 'name']);
    }

    public function testGetMovies(): void
    {
        $theMovieDBApiService = $this->getService();
        $movies = $theMovieDBApiService->getMovies();
        $this->assertAction($movies, ['id', 'genre_ids', 'title', 'release_date']);
    }

    private function getService(): TheMovieDBApiService
    {
        // boot the Symfony kernel
        self::bootKernel();
        // get container
        $container = static::getContainer();

        return $container->get(TheMovieDBApiService::class);
    }

    private function assertAction(array $data, array $keys): void
    {
        $this->assertIsArray($data);
        $item = $data[0];
        $this->assertIsArray($item);
        foreach($keys as $key) {
            $this->assertArrayHasKey($key, $item, 'the array does not contain the key "'. $key . '"');
        }
    }
}