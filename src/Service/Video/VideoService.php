<?php

namespace App\Service\Video;

class VideoService
{
    /**
     * @var array
     */
    private $providers;

    public function __construct(VideoInterface ...$providers)
    {
        $this->providers = $providers;
    }
    
    /**
     * Get the URL of the video.
     * @param array $videoData
     * @return string
     */
    public function getURLVideo(array $videoData): string
    {
        if (empty($videoData['site'])) {
            return '';
        }

        /** @var VideoInterface $provider */
        foreach ($this->providers as $provider) {
            if ($provider->getProviderName() === $videoData['site']) {
                return $provider->getURLVideo($videoData);
            }
        }

        return '';
    }
}
