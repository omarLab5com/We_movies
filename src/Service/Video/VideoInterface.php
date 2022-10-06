<?php

namespace App\Service\Video;

interface VideoInterface
{
    public function getURLVideo(array $videoData): string;
    public function getProviderName(): string;
}
