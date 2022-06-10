<?php

namespace App\Tests\Form;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Form\Test\TypeTestCase;


class RegistrationFormTest extends  TypeTestCase
{

    public function testbuilder()
    {
       $formData = [
           'username'=>'elhadj',
           'email'=>'elhadj@el.fr',
           'password'=>'password',
       ];
        $model = new User();
        $form = $this->factory->create(UserType::class, $model);
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
    }

}