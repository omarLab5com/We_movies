<?php

namespace App\Service;

class VideoService
{
    /**
     * Get the URL of the video.
     * @param array $videoData
     * @return string
     */
    public static function getURLVideo(array $videoData): string
    {
        if (empty($videoData['site'])) {
            return '';
        }

        switch($videoData['site']) {
            case 'YouTube':
                $url = 'https://www.youtube.com/embed/' . $videoData['key'];
                break;
            default:
                $url = '';
        }

        return $url;
    }
}
