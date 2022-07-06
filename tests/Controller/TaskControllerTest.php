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
        $testUser = $userRepository->findOneByUsername('username1');
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
        $testUser = $userRepository->findOneByUsername('admin');
        $client->loginUser($testUser);

        $client->request('GET', '/tasks/1/edit');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $client->submitForm('Modifier',[
            'task[title]'=>'Une tache à faire en urgence  ! ',
            'task[content]'=>'vous créerez cette tache en se référent sur l\'exemple fourni dans les documents de symfony'
        ]);
        $this->assertResponseRedirects();

        $client->followRedirect();
    }

    public function testEditActionByUser():void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByUsername('username2');
        $client->loginUser($testUser);

        $client->request('GET', '/tasks/6/edit');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $client->submitForm('Modifier',[
            'task[title]'=>'Une tache à faire en urgence  ! ',
            'task[content]'=>'Mise à jour'
        ]);
        $this->assertResponseRedirects();

        $client->followRedirect();
    }


    public function testToggleTaskAction(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByUsername('username1');
        $client->loginUser($testUser);

        $client->request('GET', '/tasks/1/toggle');

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
        $testUser = $userRepository->findOneByUsername('admin');
        $client->loginUser($testUser);


        $client->request('POST', '/tasks/4/delete');

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->assertResponseRedirects();
        $client->followRedirect();
        /** @var TaskRepository $taskRepository */
        $taskRepository = static ::getContainer()->get(TaskRepository::class);
        $task = $taskRepository->find(4);
        $this->assertNull($task);

    }

    /**
     * This is a test for deleting a task belonging to its user author
     * @return void
     */

    public function testDeleteHisTask()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByUsername('username2');
        $client->loginUser($testUser);

        $client->request('POST', '/tasks/6/delete');

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->assertResponseRedirects('/tasks');
        $client->followRedirect();
        $this->assertSelectorExists('.alert.alert-success');

        /** @var TaskRepository $taskRepository */
        $taskRepository = static ::getContainer()->get(TaskRepository::class);
        $task = $taskRepository->find(6);
        $this->assertNull($task);

    }

    /**
     * @return void
     */

    public function testDeleteAnonymeTaskByAdmin()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByUsername('admin');
        $client->loginUser($testUser);

        $client->request('POST', '/tasks/1/delete');

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->assertResponseRedirects('/tasks');
        $client->followRedirect();
        $this->assertSelectorExists('.alert.alert-success');

        /** @var TaskRepository $taskRepository */
        $taskRepository = static ::getContainer()->get(TaskRepository::class);
        $task = $taskRepository->find(1);
        $this->assertNull($task);

    }

    /**
     *  A test for the removal of an anonymous task by a user.
     * This should not be possible
     * @return void
     */

    public function testDeleteAnonymeTaskByUser()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByUsername('username1');
        $client->loginUser($testUser);

        $client->request('POST', '/tasks/1/delete');

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->assertResponseRedirects('/tasks');
        $client->followRedirect();
        $this->assertSelectorExists('.alert.alert-danger');

    }

    public function testListAction()
    {
        $client = static::createClient();
        $client->request('GET', '/tasks');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('p','une tache ANONYME');

    }

    public function testTaskActive()
    {
        $client = static::createClient();
        $client->request('GET', '/tasks-active');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('p',"une tache validée");

    }





}