<?php

namespace Tests\Feature;

use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Mockery;
use Tests\TestCase;

/**
 * Class DeleteTaskCommandTest.
 */
class DeleteTaskCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testItDeletesATask()
    {
        $task = factory(Task::class)->create();
        $this->artisan('task:delete', ['id' => $task->id]);

        $resultAsText = Artisan::output();

        $this->assertDatabaseMissing('tasks', [
            'id'      => $task->id,
            'name'    => $task->name,
            'user_id' => $task->user_id,
            'completed' => $task->completed
        ]);

        $this->assertContains('Task has been deleted to database succesfully', $resultAsText);
    }

    public function testItDeletesATaskWhithWizard()
    {
        $command = Mockery::mock('App\Console\Commands\DeleteTaskCommand[ask,choice]');
        $task = factory(Task::class)->create();

        $command->shouldReceive('choice')
            ->once()
            ->with('Task id?', [0 => $task->name])
            ->andReturn($task->name);

        $this->app['Illuminate\Contracts\Console\Kernel']->registerCommand($command);

        $this->artisan('task:delete');

        $resultAsText = Artisan::output();

        $this->assertDatabaseMissing('tasks', [
            'id'          => $task->id,
            'name'        => $task->name,
            'user_id'     => $task->user_id,
            'completed'   => $task->completed
        ]);

        $this->assertContains('Task has been deleted to database succesfully', $resultAsText);
    }
}
