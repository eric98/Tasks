<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTaskCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testItCreatesNewTask()
    {
        //1) Prepare

        //2) Execute

//        $this->artisan('route:list');
        $this->artisan('task:create', ['name' => 'Comprar pa']);
//        $this->artisan('task:create');

        //3)Assert
        // If you need result of console output
        $resultAsText = Artisan::output();

        //TODO Assert database Has?
        $this->assertDatabaseHas('tasks',['name' => 'Comprar pa']);

        //Receive "Task has been added to database succesfully."
//        $this->assertTrue(str_contains($resultAsText, 'Task has been added to database succesfully'));
        $this->assertContains('Task has been added to database succesfully',$resultAsText);
    }

    public function testItAsksForATaskNameAndThenCreatesNewTask2()
    {
        
    }
}
