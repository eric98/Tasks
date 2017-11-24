<?php

use App\Task;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(User::class,4)->create();

        initialize_task_permissions();

        create_user();

        first_user_as_task_manager();

        Artisan::call('passport:install');

        factory(Task::class,50)->create();
    }
}
