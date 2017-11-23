<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Artisan;
use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class CreateTaskCommandTest.
 *
 * @package Tests\Feature
 */
class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreTask()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $response = $this->post('/tasks_php', [ 'name' => 'Comprar llet']);

        $response->assertSuccessful();

        $this->assertDatabaseHas('tasks', [
            'name' => 'Comprar llet'
        ]);
    }


}
