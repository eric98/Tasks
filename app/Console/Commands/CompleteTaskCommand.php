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
class CompleteTaskCommand extends Command
{
    use AsksForTasks;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:complete {id? : The task id to change the status}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change the status of Complete from a task';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $id = $this->argument('id') ? $this->argument('id') : $this->askForTasks();
            $task = Task::findOrFail($id);
            $task->update([
                'completed'        => $task->completed?false:true,
            ]);
        } catch (Exception $e) {
            $this->error('Error');
        }
        $this->info('Task status has been edited to database succesfully');
    }
}
