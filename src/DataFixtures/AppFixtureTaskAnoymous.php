<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtureTaskAnoymous extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager)
    {

        $admin = new User();
        $hash = $this->userPasswordHasher->hashPassword($admin, 'azert123');
        $admin->setUsername('admin');
        $admin->setPassword($hash);
        $admin->setEmail('admin@admin.fr');
        $admin->setRoles(["ROLE_ADMIN"]);
        $manager->persist($admin);


        for ($tk = 0; $tk < 5; $tk++) {
            $taskanonym = new Task();
            $taskanonym->setTitle("La tache anonyme numéro $tk");
            $taskanonym->setContent("une tache ANONYME ");
            $manager->persist($taskanonym);
        }

        $manager->flush();
    }
}
