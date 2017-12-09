<?php

namespace Tests\Feature;

use App\Task;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Mockery;
use Tests\TestCase;

/**
 * Class EditTaskCommandTest.
 */
class EditTaskCommandTest extends TestCase
{
    use RefreshDatabase;


    public function testItEditsATask()
    {
        $task = factory(Task::class)->create();
        $this->artisan('task:edit', ['id' => $task->id, 'name' => 'Comprar pa', 'user_id' => $task->user_id]);

        $resultAsText = Artisan::output();

        $this->assertDatabaseHas('tasks', [
            'id'          => $task->id,
            'name'        => 'Comprar pa',
            'user_id'     => $task->user_id,
            'completed'   => $task->completed
        ]);

        $this->assertDatabaseMissing('tasks', [
            'id'          => $task->id,
            'name'        => $task->name,
            'user_id'     => $task->user_id,
            'completed'   => $task->completed
        ]);

        $this->assertContains('Task has been edited to database succesfully', $resultAsText);
    }

    public function testItEditsATaskWithWizard()
    {
        $command = Mockery::mock('App\Console\Commands\\EditTaskCommand[ask,choice]');
        $task = factory(Task::class)->create();
        $newUser = factory(User::class)->create();
        $user = User::findOrFail('1');

        $command->shouldReceive('choice')
            ->once()
            ->with('Task id?', [0 => $task->name])
            ->andReturn($task->name);
        $command->shouldReceive('ask')
            ->once()
            ->with('Task name?')
            ->andReturn('Nou nom');

        $command->shouldReceive('choice')
            ->once()
            ->with('User?', [0 => $user->name, 1 => $newUser->name])
            ->andReturn($newUser->name);

        $this->app['Illuminate\Contracts\Console\Kernel']->registerCommand($command);

        $this->artisan('task:edit');

        $this->assertDatabaseHas('tasks', [
            'id'          => $task->id,
            'name'        => 'Nou nom',
            'user_id'     => $newUser->id,
            'completed'   => false,
        ]);

        $this->assertDatabaseMissing('tasks', [
            'id'          => $task->id,
            'name'        => $task->name,
            'user_id'     => $task->user_id,
            'completed'   => false,
        ]);

        $resultAsText = Artisan::output();
        $this->assertContains('Task has been edited to database succesfully', $resultAsText);
    }
}
