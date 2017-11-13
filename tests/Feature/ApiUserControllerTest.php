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
        $users = factory(User::class,3)->create();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->json('GET','/api/users');
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
    public function can_show_an_user()
    {
        $user = factory(User::class)->create();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->json('GET', '/api/users/' . $user->id);

        $response->assertSuccessful();

        $response->assertJson([
            'id' => $user->id,
            'name' => $user->name,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at
        ]);
    }



    /**
     * @test
     */
    public function cannot_add_user_if_not_name_provided()
    {
        // PREPARE
        $faker = Factory::create();
        $user = factory(User::class)->create();

        $this->actingAs($user);

        // EXECUTE
        $response = $this->json('POST','/api/users');

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

        $this->actingAs($user);

        // EXECUTE
        $response = $this->json('POST','/api/users', [
            'name' => $name = $faker->word
        ]);

        // ASSERT
        $response->assertSuccessful();
        $this->assertDatabaseHas('users', [
            'name' => $name
        ]);

        $response->assertJson([
            'name' => $name
        ]);
    }

    /**
     * @test
     */
    public function can_delete_user()
    {
        $user = factory(User::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $response = $this->json('DELETE','/api/users/'.$user->id);

        $response->assertSuccessful();

        $this->assertDatabaseMissing('users',[
            'id' => $user->id
        ]);

        $response->assertJson([
            'id' => $user->id,
            'name' => $user->name
        ]);
    }

    /**
     * @test
     */
    public function cannot_delete_unexisting_user()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $response = $this->json('DELETE','/api/users/1');

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

        $this->actingAs($user);

        // EXECUTE
        $response = $this->json('PUT','/api/users/'.$user->id, [
            'name' => $newName = 'NOU NOM'
        ]);

        // ASSERT
        $response->assertSuccessful();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $newName
        ]);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'name' => $user->name
        ]);

        $response->assertJson([
            'id' => $user->id,
            'name' => $newName
        ]);
    }
}