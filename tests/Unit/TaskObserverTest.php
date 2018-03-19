<?php

namespace Tests\Unit;

use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskObserverTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_created_event_is_logged_when_task_is_created()
    {
        // CREATE TASK

        $user = factory(User::class)->create();
        $time = Carbon::now();
        $task = Task::create([
            'name'        => 'Comprar pa',
            'description' => 'Com sempre',
            'user_id'     => $user->id,
        ]);

        // An event is fired

        // A created event is logged in tasks_events table
        $this->assertDatabaseHas('task_events', [
            'time'      => $time,
            'task_name' => $task->name,
            'user_name' => $user->name,
        ]);
    }
}
