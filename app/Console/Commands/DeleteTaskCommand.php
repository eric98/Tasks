<?php

namespace App\Console\Commands;

use App\Console\Commands\Traits\AsksForTasks;
use App\Task;
use Illuminate\Console\Command;
use Mockery\Exception;

class DeleteTaskCommand extends Command
{
    use AsksForTasks;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:delete {id? : The task id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a task';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

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
            $task->delete();
        } catch (Exception $e) {
            $this->error('Error');
        }
        $this->info('Task has been deleted to database succesfully');
    }
}
