<?php

namespace App\Tests\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{


    public function testLogin(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertEquals(1, $crawler->filter(
            'input[name="username"]')->count());
        $this->assertEquals(1, $crawler->filter(
            'input[name="password"]')->count());
        $this->assertEquals(1, $crawler->filter(
            'input[name="_csrf_token"]')->count());

        $form = $crawler->selectButton('Se connecter')->form();

        $form['username'] = 'Elhdajbah6';
        $form['password'] = 'password';
        $client->submit($form);

    }






}