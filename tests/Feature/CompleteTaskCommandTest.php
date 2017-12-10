<?php

namespace Tests\Feature;

use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Mockery;
use Tests\TestCase;

/**
 * Class EditTaskCommandTest.
 */
class CompleteTaskCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testItCompleteATask()
    {
        $task = factory(Task::class)->create();
        $this->artisan('task:complete', ['id' => $task->id]);

        $resultAsText = Artisan::output();

        $this->assertDatabaseHas('tasks', [
            'id'          => $task->id,
            'name'        => $task->name,
            'user_id'     => $task->user_id,
            'completed'   => $task->completed ? 0 : 1,
        ]);

        $this->assertDatabaseMissing('tasks', [
            'id'          => $task->id,
            'name'        => $task->name,
            'user_id'     => $task->user_id,
            'completed'   => $task->completed,
        ]);

        $this->assertContains('Task status has been edited to database succesfully', $resultAsText);
    }

    public function testItCompleteATaskWithWizard()
    {
        $command = Mockery::mock('App\Console\Commands\CompleteTaskCommand[choice]');
        $task = factory(Task::class)->create();

        $command->shouldReceive('choice')
            ->once()
            ->with('Task id?', [0 => $task->name])
            ->andReturn($task->name);

        $this->app['Illuminate\Contracts\Console\Kernel']->registerCommand($command);

        $this->artisan('task:complete');

        $resultAsText = Artisan::output();

        $this->assertDatabaseHas('tasks', [
            'id'          => $task->id,
            'name'        => $task->name,
            'user_id'     => $task->user_id,
            'completed'   => $task->completed ? 0 : 1,
        ]);

        $this->assertDatabaseMissing('tasks', [
            'id'          => $task->id,
            'name'        => $task->name,
            'user_id'     => $task->user_id,
            'completed'   => $task->completed,
        ]);

        $this->assertContains('Task status has been edited to database succesfully', $resultAsText);
    }
}
