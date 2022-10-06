<?php

namespace App\Controller;

use App\Service\Api\TheMovieDBApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(TheMovieDBApiService $theMovieDBApiService): Response
    {
        $video = [];
        $movies = $theMovieDBApiService->getMovies();
        if (!empty($movies[0]['id'])) {
            $video = $theMovieDBApiService->getVideosMovie($movies[0]['id']);
        }

        return $this->render('home/index.html.twig', [
            'genres' => $theMovieDBApiService->getGenres(),
            'movies' => $movies,
            'video' => $video,
        ]);
    }
}
