<?php

namespace Tests\Feature;

use App\Task;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

/**
 * Class ListTaskCommandTest.
 */
class ListTaskCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testListTasks()
    {
        $tasks = factory(Task::class, 3)->create();
        $this->artisan('task:list');

        $resultAsText = Artisan::output();

        foreach ($tasks as $task) {
            $this->assertContains((string) $task->id, $resultAsText);
            $this->assertContains($task->name, $resultAsText);
            $this->assertContains((string) $task->completed, $resultAsText);
            $this->assertContains((string) $task->user_id, $resultAsText);
            $this->assertContains(User::findOrFail($task->user_id)->name, $resultAsText);
        }
    }
}
