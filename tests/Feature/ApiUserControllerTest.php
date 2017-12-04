<?php
/**
 * Created by PhpStorm.
 * User: alumne
 * Date: 06/11/17
 * Time: 19:50.
 */

namespace Tests\Feature;

use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiUserControllerTest extends TestCase
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
    public function can_list_users()
    {
        $users = factory(User::class, 3)->create();

        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $response = $this->json('GET', '/api/v1/users');
        $response->assertSuccessful();

        $response->assertJsonStructure([[
            'id',
            'name',
            'created_at',
            'updated_at',
        ]]);
    }

    /**
     * @test
     */
    public function can_show_an_user()
    {
        $user = factory(User::class)->create();

        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $response = $this->json('GET', '/api/v1/users/'.$user->id);

        $response->assertSuccessful();

        $response->assertJson([
            'id'         => $user->id,
            'name'       => $user->name,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ]);
    }

    /**
     * @test
     */
    public function cannot_add_user_if_not_name_provided()
    {
        // PREPARE
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api');

        // EXECUTE
        $response = $this->json('POST', '/api/v1/users');

        // ASSERT
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function can_add_a_user()
    {
        // PREPARE
        $faker = Factory::create();
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api');

        // EXECUTE
        $response = $this->json('POST', '/api/v1/users', [
            'name'  => $name = $faker->word,
            'email' => $email = $faker->email,
            'password' => $password = $faker->password,
        ]);

        // ASSERT
        $response->assertSuccessful();
        $this->assertDatabaseHas('users', [
            'name'  => $name,
            'email' => $email,
            'password' => $password,
        ]);

        $response->assertJson([
            'name'  => $name,
            'email' => $email,
        ]);
    }

    /**
     * @test
     */
    public function can_delete_user()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api');

        $response = $this->json('DELETE', '/api/v1/users/'.$user->id);

        $response->assertSuccessful();

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);

        $response->assertJson([
            'id'   => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    /**
     * @test
     */
    public function cannot_delete_unexisting_user()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api');

        $response = $this->json('DELETE', '/api/v1/users/5');

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function can_edit_user()
    {
        // PREPARE
        $user = factory(User::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api');

        // EXECUTE
        $response = $this->json('PUT', '/api/v1/users/'.$user->id, [
            'name' => $newName = 'NOU NOM',
        ]);

        // ASSERT
        $response->assertSuccessful();
        $this->assertDatabaseHas('users', [
            'id'   => $user->id,
            'name' => $newName,
            'email' => $user->email,
        ]);

        $this->assertDatabaseMissing('users', [
            'id'   => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);

        $response->assertJson([
            'id'   => $user->id,
            'name' => $newName,
            'email' => $user->email,
        ]);
    }
}
