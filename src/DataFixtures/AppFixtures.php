<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }
    public function load(ObjectManager $manager): void
    {
         $users = [];
        for ($u = 1; $u < 5; $u++) {
            $user = new User();
            $hash = $this->userPasswordHasher->hashPassword($user, 'password');
            $user->setUsername("username$u");
            $user->setEmail("username$u@gmail.com");
            $user->setPassword($hash);
            $manager->persist($user);
            $users[] = $user;
        }for ($t = 5; $t < 15; $t++) {
            $task = new Task();
            $task->setTitle("tache numéro $t");
            $task->setContent("une tache à réaliser ");
            $task->toggle(0);
            $task->setUser($users [array_rand($users)]);
            $manager->persist($task);
        }for ($t = 15; $t < 25; $t++) {
            $task = new Task();
            $task->setTitle("tache numéro $t");
            $task->setContent("une tache validée ");
            $task->toggle(1);
            $task->setUser($users [array_rand($users)]);
            $manager->persist($task);
        }
        $manager->flush();
    }
}
