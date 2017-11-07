<?php

namespace App\Console\Commands;

use App\Task;
use http\Exception;
use Illuminate\Console\Command;

class DeleteTaskCommand extends Command
{
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
    protected $description = 'Command description';

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
            $id = $this->argument('id') ? $this->argument('id') : $this->ask('Task id?');
            $task = Task::findOrFail($id);
            $task->delete();
        } catch (Exception $e) {
            $this->error('Error');
        }
        $this->info('Task has been deleted to database succesfully');
    }
}
