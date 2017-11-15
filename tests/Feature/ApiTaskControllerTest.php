<?php

namespace Tests\Feature;


use App\Task;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTaskControllerTest extends TestCase
{
    use RefreshDatabase;
    public function setUp()
    {
        parent::setUp();
//        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function can_list_tasks()
    {
        $tasks = factory(Task::class,3)->create();

        $user = factory(User::class)->create();
        $this->actingAs($user,'api');

        $response = $this->json('GET','/api/v1/tasks');
        $response->assertSuccessful();

        $response->assertJsonStructure([[
            'id',
            'name',
            'created_at',
            'updated_at'
        ]]);
    }

    /**
     * @test
     */
    public function can_show_an_task()
    {
        $task = factory(Task::class)->create();

        $user = factory(User::class)->create();
        $this->actingAs($user,'api');

        $response = $this->json('GET', '/api/v1/tasks/' . $task->id);

        $response->assertSuccessful();

        $response->assertJson([
            'id' => $task->id,
            'name' => $task->name,
            'created_at' => $task->created_at,
            'updated_at' => $task->updated_at
        ]);
    }



    /**
     * @test
     */
    public function cannot_add_task_if_not_name_provided()
    {
        // PREPARE
        $faker = Factory::create();
        $user = factory(User::class)->create();

        $this->actingAs($user,'api');

        // EXECUTE
        $response = $this->json('POST','/api/v1/tasks');

        // ASSERT
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function can_add_a_task()
    {
        // PREPARE
        $faker = Factory::create();
        $user = factory(User::class)->create();

        $this->actingAs($user,'api');

        // EXECUTE
        $response = $this->json('POST','/api/v1/tasks', [
            'name' => $name = $faker->word
        ]);

        // ASSERT
        $response->assertSuccessful();
        $this->assertDatabaseHas('tasks', [
            'name' => $name
        ]);

        $response->assertJson([
            'name' => $name
        ]);
    }

    /**
     * @test
     */
    public function can_delete_task()
    {
        $task = factory(Task::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user,'api');

        $response = $this->json('DELETE','/api/v1/tasks/'.$task->id);

        $response->assertSuccessful();

        $this->assertDatabaseMissing('tasks',[
            'id' => $task->id
        ]);

        $response->assertJson([
            'id' => $task->id,
            'name' => $task->name
        ]);
    }

    /**
     * @test
     */
    public function cannot_delete_unexisting_task()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user,'api');

        $response = $this->json('DELETE','/api/v1/tasks/1');

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function can_edit_task()
    {
        // PREPARE
        $task = factory(Task::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user,'api');

        // EXECUTE
        $response = $this->json('PUT','/api/v1/tasks/'.$task->id, [
            'name' => $newName = 'NOU NOM'
        ]);

        // ASSERT
        $response->assertSuccessful();
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'name' => $newName
        ]);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
            'name' => $task->name
        ]);

        $response->assertJson([
            'id' => $task->id,
            'name' => $newName
        ]);
    }
}