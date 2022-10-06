<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_fully_image_url_movies_db', [$this, 'getFullyImageURLMoviesDB']),
            new TwigFunction('get_url_video', [AppRuntime::class, 'getURLVideo']),
        ];
    }

    /**
     * Return the fully URL of the image.
     * 
     * @param String $imagePath
     * @param String $fileSize
     * @return String
     */
    public function getFullyImageURLMoviesDB(string $imagePath, string $fileSize): string
    {
        return $_ENV['THE_MOVIES_DB_IMAGE_BASE_URL'] . $fileSize . '/' . $imagePath;
    }
}
