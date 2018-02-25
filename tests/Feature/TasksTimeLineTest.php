<?php

namespace Tests\Feature;

use App\Task;
use App\TaskEvent;
use App\User;
use stdClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TasksTimeLineTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
//        initialize_task_permissions();
//        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function test_timeline_tasks()
    {
        // 1 Preparació
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // CREATE TASK
        $task = Task::create([
            'name' => 'Comprar pa',
            'description' => 'Com sempre',
            'user_id' => $user->id
        ]);

        // RETRIEVE
        $task2 = Task::find($task->id);

        // UPDATE TASK
        $task->update([
            'name' => 'Comprar oli'
        ]);

        // DELETE TASK
        $task->delete();

        // 2 Execució

        //Interficies: API / Web
        $response = $this->get('/tasks/timeline');

        $response->assertSuccessful();

        $task_events = TaskEvent::all();

        $response->assertViewIs('timeline');
        $response->assertViewHas('task_events',$task_events);

//        $response->assertSee('User '.$user->name.' created task '.$task->name.' at '.$task->created_at);
//        $response->assertSee('User '.$user->name.' retrieved task '.$task->name.' at ');
//        $response->assertSee('User '.$user->name.' updated task '.$task->name.' at '); // PAYLOAD: informar nom anterior nom nou
    }
}
