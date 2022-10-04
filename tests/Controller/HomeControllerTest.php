<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogControllerTest extends WebTestCase
{
    public function testIndex():void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'A propos de We Movies');
        $this->assertSelectorExists('input#search');
        $this->assertSelectorNotExists('.form-search-results-wrapper .card');
        $this->assertSelectorExists('div.col-md-4');
        $this->assertSelectorExists('div.col-md-8');
        $this->assertSelectorExists('div.col-md-8 img');
    }
}
