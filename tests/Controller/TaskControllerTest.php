<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TaskControllerTest extends WebTestCase
{

    public function testCreateAction():void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByUsername('Elhdajbah6');
        $client->loginUser($testUser);

        $client->request('GET', '/tasks/create');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $client->submitForm('Ajouter',[
            'task[title]'=>'Une tache à faire en urgence',
            'task[content]'=>'vous créerez cette tache en se referent sur l\'exemple fourni'
        ]);
        $this->assertResponseRedirects();

        $client->followRedirect();
    }

    public function testEditAction():void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByUsername('Elhdajbah6');
        $client->loginUser($testUser);

        $client->request('GET', '/tasks/26/edit');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $client->submitForm('Modifier',[
            'task[title]'=>'Une tache à faire en urgence ! ',
            'task[content]'=>'vous créerez cette tache en se référent sur l\'exemple fourni dans les documents de symfony'
        ]);
        $this->assertResponseRedirects();

        $client->followRedirect();
    }







}