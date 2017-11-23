<?php

use Spatie\Permission\Models\Permission;

function initialize_task_permission() {
    Permission::create(['name' => 'list-tasks']);
}