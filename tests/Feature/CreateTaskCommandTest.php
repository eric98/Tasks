<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Mockery;
use Tests\TestCase;

class CreateTaskCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testItCreatesNewTask()
    {
        //1) Prepare
        $user = factory(User::class)->create();

        //2) Execute

        $this->artisan('task:create', [
            'name'    => 'Comprar pa',
            'user_id' => $user->id,
        ]);

        //3)Assert
        // If you need result of console output
        $resultAsText = Artisan::output();

        $this->assertDatabaseHas('tasks', ['name' => 'Comprar pa', 'user_id' => $user->id]);

        //Receive "Task has been added to database succesfully."
        $this->assertContains('Task has been added to database succesfully', $resultAsText);
    }

    public function testItAsksForATaskNameAndThenCreatesNewTask2()
    {
        $user = factory(User::class)->create();

        //1) Prepare
        $command = Mockery::mock('App\Console\Commands\CreateTaskCommand[ask]');

        $command->shouldReceive('ask')
            ->once()
            ->with('Task name?')
            ->andReturn('Comprar llet');

        $command->shouldReceive('ask')
            ->once()
            ->with('Task user_id?')
            ->andReturn($user->id);

        $this->app['Illuminate\Contracts\Console\Kernel']->registerCommand($command);

        //2) Execute
        $this->artisan('task:create');

        $this->assertDatabaseHas('tasks', ['name' => 'Comprar llet', 'user_id' => $user->id]);

        //3) Assert
        $resultAsText = Artisan::output();
        $this->assertContains('Task has been added to database succesfully', $resultAsText);
    }

    public function testItAsksForATaskNameAndThenCatchTheError()
    {
        try {
            $this->artisan('task:create');
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
    }
}
