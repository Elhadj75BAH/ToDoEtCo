<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class UserEntityTest extends KernelTestCase
{

    private User $user;
    private Task $task;
    public function setUp(): void
    {
        $this->user = new User();
        $this->task = new Task();

    }

    public function testId(): void
    {
        $this->assertNull($this->user->getId());
    }

    public function testUsername(): void
    {
        $this->user->setUsername('username');
        $this->assertSame('username', $this->user->getUsername());
    }

    public function testPassword(): void
    {
        $this->user->setPassword('password');
        $this->assertSame('password', $this->user->getPassword());
    }

    public function testSalt(): void
    {
        $this->assertNull($this->user->getSalt());
    }


    public function testEmail(): void
    {
        $this->user->setEmail('your@email.fr');
        $this->assertSame('your@email.fr', $this->user->getEmail());
    }

    public function testRoles(): void
    {
        $this->user->setRoles(['ROLE_USER']);
        $this->assertSame(['ROLE_USER'], $this->user->getRoles());
    }

    public function testTask()
    {
        $this->user->addTask($this->task);
        $this->assertCount(1, $this->user->getTask());

        $tasks = $this->user->getTask();
        $this->assertSame($this->user->getTask(), $tasks);

        $this->user->removeTask($this->task);
        $this->assertCount(0, $this->user->getTask());
    }


}
