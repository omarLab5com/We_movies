<?php

namespace App\Service\Api;

interface TheMovieDBApiInterface
{
    public function getData(string $api): array;
}