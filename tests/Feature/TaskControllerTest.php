<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class CreateTaskCommandTest.
 */
class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreTask()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $response = $this->post('/tasks_php', ['name' => 'Comprar llet']);

        $response->assertSuccessful();

        $this->assertDatabaseHas('tasks', [
            'name' => 'Comprar llet',
        ]);
    }
}
