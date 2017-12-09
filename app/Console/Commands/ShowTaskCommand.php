<?php

namespace App\Console\Commands;

use App\Console\Commands\Traits\AsksForTasks;
use App\Task;
use App\User;
use Illuminate\Console\Command;
use Mockery\Exception;

/**
 * Class ShowTaskCommand.
 */
class ShowTaskCommand extends Command
{
    use AsksForTasks;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:show {id? : The task id to edit}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show a task';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $id = $this->argument('id') ? $this->argument('id') : $this->askForTasks();
        $task = Task::findOrFail($id);
        $user = User::findOrFail($task->user_id);

        $this->info('Task:');

        try {
            $headers = ['Key', 'Value'];

            $fields = [
              ['Name:', $task->name],
                ['Completed:', $task->completed?'Yes':'No',],
              ['User id:', $task->user_id],
              ['User name:', $user->name],
            ];

            $this->table($headers, $fields);
        } catch (Exception $e) {
            $this->error('Error');
        }
    }
}
