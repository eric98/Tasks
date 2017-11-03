<?php

namespace App\Console\Commands;

use App\Task;
use Illuminate\Console\Command;
use Mockery\Exception;

class CreateTaskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:create {name? : The task name}';

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
        //TODO fer un test que provoque l'error i que mire si surt l'error
        try {
            Task::create([
                'name' => $this->argument('name') ? $this->argument('name') : $this->ask('Task name?')
            ]);
        } catch (Exception $e) {
            $this->error('Error');
        }
        $this->info('Task has been added to database succesfully');
    }
}
