<?php

namespace App\Controller;

use App\Service\TheMovieDBApiService;
use App\Service\VideoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    /**
     * @Route("/show/{id}", name="app_show_movie")
     */
    public function show(Request $request, int $id, TheMovieDBApiService $theMovieDBApiService): Response
    {
        return $this->render('movies/show.html.twig', [
            'video' => $theMovieDBApiService->getVideosMovie($id),
            'movie' => $theMovieDBApiService->getDetailMovie($id),
        ]);
    }

    /**
     * @Route("/ajax-search-movies", name="app_ajax_search_movies", options={"expose"=true}, methods={"POST"})
     */
    public function searchMovies(Request $request, TheMovieDBApiService $theMovieDBApiService): Response
    {
        if (!$request->isXMLHttpRequest()) {
            throw new \Exception('Erreur');
        }

        $res = [];
        $movies = $theMovieDBApiService->getMovies();
        $needle = $request->request->get('needle');
        foreach ($movies as $movie) {
            if (stripos($movie['title'], $needle) !== false) {
                $res[] = $movie;
            }
        }

        $data = $this->render('movies/_search_movies.html.twig', [
            'movies' => $res,
        ]);

        return $this->json(['isValid' => true, 'content' => $data->getContent()], 200);
    }

    /**
     * @Route("/ajax-movies-by-genres", name="app_ajax_movies_by_genres", options={"expose"=true}, methods={"POST"})
     */
    public function moviesByGenres(Request $request, TheMovieDBApiService $theMovieDBApiService): Response
    {
        if (!$request->isXMLHttpRequest()) {
            throw new \Exception('Erreur');
        }

        $video = [];
        $moviesIds = $request->request->get('genresIds');
        $movies = $theMovieDBApiService->getMovies($moviesIds);
        $data = $this->render('movies/_movies_by_genres.html.twig', [
            'movies' => $movies,
        ]);
        if (!empty($movies[0]['id'])) {
            $video = $theMovieDBApiService->getVideosMovie($movies[0]['id']);
        }

        return $this->json(['isValid' => true, 'content' => $data->getContent(), 'videoUrl' => VideoService::getURLVideo($video)], 200);
    }

    /**
     * @Route("/ajax-detail-movie/{id}", name="app_ajax_detail_movie", options={"expose"=true}, methods={"GET"})
     */
    public function detail(int $id, Request $request, TheMovieDBApiService $theMovieDBApiService): Response
    {
        if (!$request->isXMLHttpRequest()) {
            throw new \Exception('Erreur');
        }

        $data = $this->render('movies/_detail.html.twig', [
            'video' => $theMovieDBApiService->getVideosMovie($id),
            'movie' => $theMovieDBApiService->getDetailMovie($id),
        ]);

        return $this->json(['isValid' => true, 'content' => $data->getContent()], 200);
    }
}
