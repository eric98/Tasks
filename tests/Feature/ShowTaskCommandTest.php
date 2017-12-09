<?php

namespace Tests\Feature;

use App\Task;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Mockery;
use Tests\TestCase;

/**
 * Class ShowTaskCommandTest.
 */
class ShowTaskCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testItShowATask()
    {
        $task = factory(Task::class)->create();
        $this->artisan('task:show', ['id' => $task->id]);

        $resultAsText = Artisan::output();

        $this->assertContains('Name: ', $resultAsText);
        $this->assertContains($task->name, $resultAsText);

        $this->assertContains('Completed: ', $resultAsText);
        $this->assertContains($task->completed?'Yes':'No', $resultAsText);

        $this->assertContains('User id: ', $resultAsText);
        $this->assertContains((string) $task->user_id, $resultAsText);

        $this->assertContains('User name: ', $resultAsText);
        $this->assertContains(User::findOrFail($task->user_id)->name, $resultAsText);
    }

    public function testItShowATaskWithWizard()
    {
        $command = Mockery::mock('App\Console\Commands\ShowTaskCommand[ask,choice]');
        $task = factory(Task::class)->create();

        $command->shouldReceive('choice')
            ->once()
            ->with('Task id?', [0 => $task->name])
            ->andReturn($task->name);

        $this->app['Illuminate\Contracts\Console\Kernel']->registerCommand($command);

        $this->artisan('task:show');

        $resultAsText = Artisan::output();

        $this->assertContains('Name: ', $resultAsText);
        $this->assertContains($task->name, $resultAsText);

        $this->assertContains('Completed: ', $resultAsText);
        $this->assertContains($task->completed?'Yes':'No', $resultAsText);

        $this->assertContains('User id: ', $resultAsText);
        $this->assertContains((string) $task->user_id, $resultAsText);

        $this->assertContains('User name: ', $resultAsText);
        $this->assertContains(User::findOrFail($task->user_id)->name, $resultAsText);
    }
}
