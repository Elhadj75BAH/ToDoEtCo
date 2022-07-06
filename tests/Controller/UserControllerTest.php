<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;


class UserControllerTest extends WebTestCase
{

    public function testRegister()
    {
        $client = static::createClient();
        $client->request('GET', '/register');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);


        $client->submitForm('Inscription',[
            'registration_form[username]'=>'username10',
            'registration_form[password][first]'=>'Password',
            'registration_form[password][second]'=>'Password',
            'registration_form[email]'=>'username222@test.fr',
            'registration_form[agreeTerms]'=>'1',
        ]);
        $this->assertResponseRedirects();

       $client->followRedirect();
    }


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


    public function testCreateAction(): void
    {

        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByUsername('admin');
        $client->loginUser($testUser);

       $client->request('GET', '/users/create');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $client->submitForm('Ajouter',[
            'user[username]'=>'flow2',
            'user[password][first]'=>'Password',
            'user[password][second]'=>'Password',
            'user[email]'=>'flow2@test.fr',
        ]);
        $this->assertResponseRedirects();

        $client->followRedirect();

    }

    public function testCreateActionByUser(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByUsername('Username1');
        $client->loginUser($testUser);

        $client->request('GET', '/users/create');

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);

    }


    public function testEditAction()
    {

        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByUsername('admin');
        $client->loginUser($testUser);

        $client->request('GET', '/users/3/edit');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $client->submitForm('Modifier',[
            'user[username]'=>'baro',
            'user[password][first]'=>'password',
            'user[password][second]'=>'password',
            'user[email]'=>'barry@test.fr',
        ]);

        $this->assertResponseRedirects();
        $client->followRedirect();

        $userRepository = static ::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->find(48);
        $this->assertNull($testUser);

    }


    public function  testProfileUser()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByUsername('Username1');
        $client->loginUser($testUser);

        $client->request('GET', '/profile');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

    }

    public function  testAccessToTheOfflineProfile()
    {
        $client = static::createClient();
        $client->request('GET', '/profile');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->assertResponseRedirects();

    }

    public function  testListUsers()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByUsername('admin');
        $client->loginUser($testUser);

        $client->request('GET', '/users');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

    }


    public function  testAccessForAnUnauthorizedUser()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByUsername('username1');
        $client->loginUser($testUser);

        $client->request('GET', '/users');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);

    }



}