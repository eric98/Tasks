<?php

namespace Tests\Feature;

use App\Task;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

/**
 * Class CreateTaskCommandTest.
 */
class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Set up tests.
     */
    public function setUp()
    {
        parent::setUp();
        initialize_task_permissions();
//        $this->withoutExceptionHandling();
    }

    protected function loginAsTaskManager()
    {
        $user = factory(User::class)->create();
        $user->assignRole('task-manager');
        $this->actingAs($user);
        View::share('user', $user);
    }

    public function testListTasks()
    {
        factory(Task::class, 3)->create();

        $user = factory(User::class)->create();
        $this->actingAs($user);
        View::share('user', $user);

        $response = $this->get('/tasks_php');

        $response->assertSuccessful();

        $response->assertSuccessful();
        $response->assertViewIs('tasks_php');
        $tasks = Task::all();
        $response->assertViewHas('tasks', $tasks);

        foreach ($tasks as $task) {
            $response->assertSee((string)$task->id);
            $response->assertSeeText($task->name);
            $response->assertSeeText($task->completed?'Completed':'Pending');
            $response->assertSee($task->user_id);
            $response->assertSeeText(User::findOrFail($task->user_id)->name);
        }
    }

    public function testShowATask()
    {
        $task = factory(Task::class)->create();
        $this->loginAsTaskManager();
        $user = factory(User::class)->create();

        $response = $this->get('/tasks_php/'.$task->id);

        $response->assertSuccessful();
        $response->assertViewIs('show_tasks');
        $response->assertViewHas('task');

        $response->assertSee((string)$task->id);
        $response->assertSeeText($task->name);
        $response->assertSeeText('Status');
        $response->assertSeeText($task->completed?'Completed':'Pending');
        $response->assertSee((string)$task->user_id);
        $response->assertSeeText(User::findOrFail($task->user_id)->name);
    }

    public function testStoreTask()
    {
        $this->loginAsTaskManager();
        $user = factory(User::class)->create();
        $response = $this->post('/tasks_php', ['name' => 'Comprar llet', 'user_id' => $user->id, 'completed' => false]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('tasks', [
            'name'      => 'Comprar llet',
            'user_id'   => $user->id,
            'completed' => false,
        ]);
    }

    public function testCompleteTask()
    {
        $this->loginAsTaskManager();
        $task = factory(Task::class)->create();

        $response = $this->get('/tasks_php/statuschance/'.$task->id);

        $response->assertStatus(302);

        $this->assertDatabaseHas('tasks', [
            'id'          => $task->id,
            'name'        => $task->name,
            'user_id' => $task->user_id,
            'completed' => $task->completed?false:true
        ]);

        $this->assertDatabaseMissing('tasks', [
            'id'          => $task->id,
            'name'        => $task->name,
            'user_id' => $task->user_id,
            'completed' => $task->completed?true:false
        ]);
    }

    public function testUpdateTask()
    {
        $this->loginAsTaskManager();
        $task = factory(Task::class)->create();
        $newTask = factory(Task::class)->make();

        $response = $this->put('/tasks_php/'.$task->id, [
            'name'        => $newTask->name,
            'user_id'     => $newTask->user_id,
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('tasks', [
            'id'          => $task->id,
            'name'        => $newTask->name,
        ]);

        $this->assertDatabaseMissing('tasks', [
            'id'          => $task->id,
            'name'        => $task->name,
        ]);
    }

    public function testDestroyTask()
    {
        $this->loginAsTaskManager();

        $task = factory(Task::class)->create();

        $response = $this->delete('/tasks_php/'.$task->id);

        $this->assertDatabaseMissing('tasks', [
            'name'        => $task->name,
        ]);

        $response->assertRedirect('tasks_php');
    }
}
