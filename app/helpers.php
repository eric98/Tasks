<?php

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

if (! function_exists('initialize_task_permission')){
    function initialize_task_permission() {
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