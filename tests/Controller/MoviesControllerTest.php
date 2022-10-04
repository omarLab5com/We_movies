<?php

namespace App\Test\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MoviesControllerTest  extends WebTestCase
{
    public function testShow(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/show/278');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'A propos de We Movies');
        $this->assertSelectorExists('input#search');
        $this->assertSelectorNotExists('.form-search-results-wrapper .card');
        $this->assertSelectorExists('div.card');
        $this->assertSelectorExists('img');
    }
}