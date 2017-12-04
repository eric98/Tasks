<?php

namespace App\Console\Commands;

use App\Task;
use Illuminate\Console\Command;

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
            $headers = ['id', 'Name', 'Completed'];

            $users = Task::all(['id', 'name', 'completed'])->toArray();
//            foreach ($users as $user){
//                if ($user['completed'] == 1){
//                    $user['completed'] = true;
//                } else {
//                    $user['completed'] = false;
//                }
//            }
        } catch (Exception $e) {
            $this->error('Error');
        }
        $this->table($headers, $users);
    }
}
