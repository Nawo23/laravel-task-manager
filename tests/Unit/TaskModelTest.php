<?php

namespace Tests\Unit;

use App\Models\Task;
use PHPUnit\Framework\TestCase;

class TaskModelTest extends TestCase
{
    public function test_task_is_done_returns_true_when_status_is_done(): void
    {
        $task = new Task(['status' => 'done']);
        $this->assertTrue($task->isDone());
    }

    public function test_task_is_done_returns_false_when_status_is_pending(): void
    {
        $task = new Task(['status' => 'pending']);
        $this->assertFalse($task->isDone());
    }

    public function test_task_is_pending_returns_true_when_status_is_pending(): void
    {
        $task = new Task(['status' => 'pending']);
        $this->assertTrue($task->isPending());
    }

    public function test_task_status_constants_are_correct(): void
    {
        $this->assertEquals('pending', Task::STATUS_PENDING);
        $this->assertEquals('done', Task::STATUS_DONE);
    }
}
