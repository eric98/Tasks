<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTaskCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testItCreatesNewTask()
    {
        //1) Prepare

        //2) Execute

        $this->artisan('task:create', ['name' => 'Comprar pa']);

        //3)Assert
        // If you need result of console output
        $resultAsText = Artisan::output();

        $this->assertDatabaseHas('tasks',['name' => 'Comprar pa']);

        //Receive "Task has been added to database succesfully."
//        $this->assertTrue(str_contains($resultAsText, 'Task has been added to database succesfully'));
        $this->assertContains('Task has been added to database succesfully',$resultAsText);
    }

    public function testItAsksForATaskNameAndThenCreatesNewTask2()
    {
        //1) Prepare
        $command = Mockery::mock('App\Console\Commands\CreateTaskCommand[ask]');

        $command->shouldReceive('ask')
            ->once()
            ->with('Task name?')
            ->andReturn('Comprar llet');

        $this->app['Illuminate\Contracts\Console\Kernel']->registerCommand($command);

        //2) Execute
        $this->artisan('task:create');

        $this->assertDatabaseHas('tasks',['name' => 'Comprar llet']);

        //3) Assert
        $resultAsText = Artisan::output();
        $this->assertContains('Task has been added to database succesfully',$resultAsText);
    }

    public function testItAsksForATaskNameAndThenCatchTheError()
    {
        //1) Prepare

        //2) Execute
        $this->artisan('task:create')
            ->setExpectedException();
//            ->assertSessionHasErrors($bindings = [], $format = null);



        //3)Assert
        // If you need result of console output
//        $resultAsText = Artisan::output();
//
//        dd($resultAsText);

//        $this->assertDatabaseHas('tasks',['name' => 'Comprar pa']);

        //Receive "Task has been added to database succesfully."
//        $this->assertTrue(str_contains($resultAsText, 'Task has been added to database succesfully'));
//        $this->assertContains('Task has been added to database succesfully',$resultAsText);
    }
}
