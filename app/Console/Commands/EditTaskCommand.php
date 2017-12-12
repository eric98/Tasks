<?php

namespace App\Console\Commands;

use App\Console\Commands\Traits\AsksForTasks;
use App\Console\Commands\Traits\AsksForUsers;
use App\Task;
use Illuminate\Console\Command;
use Mockery\Exception;

/**
 * Class EditTaskCommand.
 */
class EditTaskCommand extends Command
{
    use AsksForTasks;
    use AsksForUsers;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:edit {id? : The task id} {name? : The task name} {user_id? : The user id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Edit a task';

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
            $task->update([
                'name'        => $this->argument('name') ? $this->argument('name') : $this->ask('Task name?',$task->name),
                'user_id'     => $this->argument('user_id') ? $this->argument('user_id') : $this->askForUsers(),
            ]);
        } catch (Exception $e) {
            $this->error('Error');
        }
        $this->info('Task has been edited to database succesfully');
    }
}
