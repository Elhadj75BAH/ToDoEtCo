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

    /**
     * This is a test for deleting any task by an admin (anonymous task or task user related)
     * @return void
     */

    public function testDeleteTaskAction()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByUsername('Elhdajbah6');
        $client->loginUser($testUser);


        $client->request('POST', '/tasks/44/delete');

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->assertResponseRedirects();
        /** @var TaskRepository $taskRepository */
        $taskRepository = static ::getContainer()->get(TaskRepository::class);
        $task = $taskRepository->find(44);
        $this->assertNull($task);

    }

    /**
     * This is a test for deleting a task belonging to its user author
     * @return void
     */

    public function testDeleteMyTask()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByUsername('baro');
        $client->loginUser($testUser);


        $client->request('POST', '/tasks/6/delete');

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->assertResponseRedirects();
        /** @var TaskRepository $taskRepository */
        $taskRepository = static ::getContainer()->get(TaskRepository::class);
        $task = $taskRepository->find(6);
        $this->assertNull($task);

    }

    /**
     * A test for the removal of an anonymous task by a user.
     * This should not be possible
     * @return void
     */

    public function testDeleteAnonymeTask()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByUsername('baro');
        $client->loginUser($testUser);


        $client->request('POST', '/tasks/44/delete');

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->assertResponseRedirects();
        /** @var TaskRepository $taskRepository */
        $taskRepository = static ::getContainer()->get(TaskRepository::class);
        $task = $taskRepository->find(44);
        $this->assertNull($task);

    }




}