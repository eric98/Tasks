<?php

use App\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

if (!function_exists('initialize_task_permission')) {
    function initialize_task_permissions()
    {
        Permission::firstOrCreate(['name' => 'list-tasks']);
        Permission::firstOrCreate(['name' => 'show-tasks']);
        Permission::firstOrCreate(['name' => 'store-tasks']);
        Permission::firstOrCreate(['name' => 'update-tasks']);
        Permission::firstOrCreate(['name' => 'destroy-tasks']);

        $role = Role::firstOrCreate(['name' => 'task-manager']);

        $role->givePermissionTo('list-tasks');
        $role->givePermissionTo('show-tasks');
        $role->givePermissionTo('store-tasks');
        $role->givePermissionTo('update-tasks');
        $role->givePermissionTo('destroy-tasks');
    }
}

if (!function_exists('create_user')) {
    function create_user()
    {
        factory(User::class)->create([
            'name'     => env('TASKS_USER_NAME', 'Eric Garcia Reverter'),
            'email'    => env('TASKS_USER_EMAIL', 'ergare.17@gmail.com'),
            'password' => bcrypt(env('TASKS_USER_PASSWORD')),
        ]);

        factory(User::class)->create([
            'name'     => env('TASKS_USER_NAME_2', 'Sergi Tur Badenas'),
            'email'    => env('TASKS_USER_EMAIL_2', 'sergiturbadenas@gmail.com'),
            'password' => bcrypt(env('TASKS_USER_PASSWORD_2')),
        ]);
    }
}

if (!function_exists('first_user_as_task_manager')) {
    function first_user_as_task_manager()
    {
        User::all()->first()->assignRole('task-manager');
//        User::findOrFail('2')->assignRole('task-manager');
    }
}
