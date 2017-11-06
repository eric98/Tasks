<?php
/**
 * Created by PhpStorm.
 * User: alumne
 * Date: 06/11/17
 * Time: 19:50
 */

namespace Tests\Feature;


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
    public function cannot_add_task_if_not_logged()
    {
        $faker = Factory::create();

        // EXECUTE
        $response = $this->json('POST','/api/tasks', [
            'name' => $name = $faker->word
        ]);

        // ASSERT
        $response->assertStatus(401);
    }

    /**
     * @test
     */
    public function cannot_add_task_if_not_name_provided()
    {
        // PREPARE
        $faker = Factory::create();
        $user = factory(User::class)->create();

        $this->actingAs($user);

        // EXECUTE
        $response = $this->json('POST','/api/tasks');

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

        $this->actingAs($user);

        // EXECUTE
        $response = $this->json('POST','/api/tasks', [
            'name' => $name = $faker->word
        ]);

        // ASSERT
        $response->assertSuccessful();
        $this->assertDatabaseHas('tasks', [
            'name' => $name
        ]);
    }
}