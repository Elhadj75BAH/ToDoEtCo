<?php

namespace App\Tests\Controller;

use App\Repository\TaskRepository;
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

        $client->request('GET', '/tasks/29/edit');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $client->submitForm('Modifier',[
            'task[title]'=>'Une tache à faire en urgence  ! ',
            'task[content]'=>'vous créerez cette tache en se référent sur l\'exemple fourni dans les documents de symfony'
        ]);
        $this->assertResponseRedirects();

        $client->followRedirect();
        $taskRepository = static ::getContainer()->get(TaskRepository::class);
        $task = $taskRepository->find(29);
        $this->assertNull($task);
    }


    public function testToggleTaskAction(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByUsername('Elhdajbah6');
        $client->loginUser($testUser);

        $client->request('GET', '/tasks/29/toggle');

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->assertResponseRedirects();

        $client->followRedirect();

    }



    public function testDeleteTaskAction()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByUsername('Elhdajbah6');
        $client->loginUser($testUser);


        $client->request('POST', '/tasks/32/delete');

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->assertResponseRedirects();

        $taskRepository = static ::getContainer()->get(TaskRepository::class);
        $task = $taskRepository->find(28);
        $this->assertNull($task);

    }

}