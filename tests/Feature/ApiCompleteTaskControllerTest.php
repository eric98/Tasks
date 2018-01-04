<?php

namespace Tests\Feature;

use App\Task;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ApiCompleteTaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        initialize_task_permissions();
        Artisan::call('passport:install');
//        $this->withoutExceptionHandling();
    }

    protected function loginAndAuthorize()
    {
        $user = factory(User::class)->create();
        $user->assignRole('task-manager');
        $this->actingAs($user, 'api');

        return $user;
    }

    /**
     * @test
     */
    public function can_complete_task()
    {
        $task = factory(Task::class)->create();
        $user = $this->loginAndAuthorize();

        $response = $this->json('POST', '/api/v1/complete-task/'.$task->id);

        $response->assertSuccessful();
        $this->assertDatabaseHas('tasks', [
            'id'        => $task->id,
            'name'      => $task->name,
            'description' => $task->description,
            'user_id'   => $task->user_id,
            'completed' => true,
        ]);

        $this->assertDatabaseMissing('tasks', [
            'id'        => $task->id,
            'name'      => $task->name,
            'description' => $task->description,
            'user_id'   => $task->user_id,
            'completed' => $task->completed,
        ]);

        $response->assertJson([
            'id'        => $task->id,
            'name'      => $task->name,
            'description' => $task->description,
            'user_id'   => $task->user_id,
            'completed' => true,
        ]);
    }

    /**
     * @test
     */
    public function can_incomplete_task()
    {
        $task = factory(Task::class)->create();
        $user = $this->loginAndAuthorize();

        $this->json('POST', '/api/v1/complete-task/'.$task->id);
        $response = $this->json('DELETE', '/api/v1/complete-task/'.$task->id);

        $response->assertSuccessful();
        $this->assertDatabaseHas('tasks', [
            'id'        => $task->id,
            'name'      => $task->name,
            'description' => $task->description,
            'user_id'   => $task->user_id,
            'completed' => false,
        ]);

        $this->assertDatabaseMissing('tasks', [
            'id'        => $task->id,
            'name'      => $task->name,
            'description' => $task->description,
            'user_id'   => $task->user_id,
            'completed' => true,
        ]);

        $response->assertJson([
            'id'        => $task->id,
            'name'      => $task->name,
            'description' => $task->description,
            'user_id'   => $task->user_id,
            'completed' => false,
        ]);
    }
}
