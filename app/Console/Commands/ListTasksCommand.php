<?php

namespace App\Console\Commands;

use App\Task;
use App\User;
use Illuminate\Console\Command;
use Mockery\Exception;

class ListTasksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all tasks';

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
            $tasks = Task::all();

            $headers = ['id', 'Name', 'Completed', 'User id', 'User Name'];
            $fields = [];
            foreach ($tasks as $task) {
                $fields[] = [
                    'id:'               => $task->id,
                    'Name:'             => $task->name,
                    'Completed:'        => $task->completed ? 'Yes' : 'No',
                    'User id:'          => $task->user_id,
                    'User name:'        => User::findOrFail($task->user_id)->name,
                ];
            }
        } catch (Exception $e) {
            $this->error('Error');
        }
        $this->table($headers, $fields);
    }
}
