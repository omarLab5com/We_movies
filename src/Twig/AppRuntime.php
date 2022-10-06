<?php

namespace App\Twig;

use App\Service\Video\VideoService;
use Twig\Extension\RuntimeExtensionInterface;

class AppRuntime implements RuntimeExtensionInterface
{
    private VideoService $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

    /**
     * Return the URL of the video.
     * 
     * @param array $videoData
     * @return String
     */
    public function getURLVideo(array $videoData): string
    {
        return $this->videoService->getURLVideo($videoData);
    }
}