<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class TaskTest extends KernelTestCase
{

    private Task $task;

    public function setUp(): void
    {
        $this->task = new Task();
    }

    public function testId(): void
    {
        $this->assertNull($this->task->getId());
    }

    public function testTitle()
    {
        $this->task->setTitle('title');
        $this->assertSame('title',
            $this->task->getTitle());
    }

    public function testContent()
    {
        $this->task->setContent('content');
        $this->assertSame('content', $this->task->getContent());
    }

    public function testIsDone()
    {

        $this->task->isDone(true);
        $this->task->toggle(true);
        $this->assertSame(true, $this->task->isDone());
        $this->assertSame(true, $this->task->isDone());
    }

    public function testCreatedAt()
    {
        $date = new \DateTime();
        $this->task->setCreatedAt($date);
        $this->assertSame($date, $this->task->getCreatedAt());
    }

    public function testAuthor()
    {
        $this->task->setUser(new User());
        $this->assertInstanceOf(User::class, $this->task->getUser());
    }

}
