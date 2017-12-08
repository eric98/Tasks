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

    /**
     * Can list tasks.
     *
     * @test
     */
    public function can_list_tasks()
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
            $response->assertSee($task->name);
        }
    }

    /*
     * Can show a task.
     *
     * @test
     */
    public function can_show_a_task()
    {
        $task = factory(Task::class)->create();
        $user = factory(User::class)->create();
        $this->actingAs($user);
        View::share('user', $user);

        $response = $this->get('/tasks_php/'.$task->id);

        $response->assertSuccessful();
        $response->assertViewIs('show_task');
        $response->assertViewHas('task');

        $response->assertSeeText($task->name);
    }

    public function testStoreTask()
    {
        $this->loginAsTaskManager();
        $user = factory(User::class)->create();
        $response = $this->post('/tasks_php', ['name' => 'Comprar llet','user_id' => $user->id,'completed' => false]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('tasks', [
            'name' => 'Comprar llet',
            'user_id' => $user->id,
            'completed' => false
        ]);
    }

    /*
     * Update a task.
     */
//    public function testUpdateTask()
//    {
//        $task = factory(Task::class)->create();
//
//        $newTask = factory(Task::class)->make();
//        $response = $this->put('/tasks_php/'.$task->id, [
//            'name'        => $newTask->name,
//        ]);
//
//        $this->assertDatabaseHas('tasks_php', [
//            'id'          => $task->id,
//            'name'        => $newTask->name,
//        ]);
//
//        $this->assertDatabaseMissing('tasks_php', [
//            'id'          => $task->id,
//            'name'        => $task->name,
//        ]);
//
//        $response->assertRedirect('tasks/edit');
//    }
}
