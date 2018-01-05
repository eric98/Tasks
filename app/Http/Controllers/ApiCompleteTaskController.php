<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyCompletedTask;
use App\Http\Requests\StoreCompletedTask;
use App\Task;

class ApiCompleteTaskController extends Controller
{
    public function store(StoreCompletedTask $request, Task $task)
    {
        $task->completed = true;
        $task->save();
        return $task;
    }

    public function destroy(DestroyCompletedTask $request, Task $task)
    {
        $task->completed = false;
        $task->save();
        return $task;
    }
}
