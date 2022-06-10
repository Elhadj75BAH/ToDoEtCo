<?php

namespace App\Tests\Controller;



use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;


class UserControllerTest extends WebTestCase
{

    public function testCreatAction()
    {
        $client = static::createClient();
        $client->request('GET', '/register');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);


        $client->submitForm('Inscription',[
            'registration_form[username]'=>'Elhdajbah7',
            'registration_form[password][first]'=>'Password',
            'registration_form[password][second]'=>'Password',
            'registration_form[email]'=>'elhaddjbahtest7@test.fr',
            'registration_form[agreeTerms]'=>'1',
        ]);
        $this->assertResponseRedirects();

       $client->followRedirect();
    }



}