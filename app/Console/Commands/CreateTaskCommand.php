<?php

namespace App\Console\Commands;

use App\Console\Commands\Traits\AsksForUsers;
use App\Task;
use Illuminate\Console\Command;
use Mockery\Exception;

class CreateTaskCommand extends Command
{
    use AsksForUsers;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:create {name? : The task name} {description? : The task description} {user_id? : The user id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a task';

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
            Task::create([
                'name'        => $this->argument('name') ? $this->argument('name') : $this->ask('Task name?'),
                'description'        => $this->argument('description') ? $this->argument('description') : $this->ask('Task description?'),
                'user_id'     => $this->argument('user_id') ? $this->argument('user_id') : $this->askForUsers(),
                'completed'   => false,
            ]);
        } catch (Exception $e) {
            $this->error('Error');
        }
        $this->info('Task has been added to database succesfully');
    }
}
