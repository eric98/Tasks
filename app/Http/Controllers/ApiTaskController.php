<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompleteTask;
use App\Http\Requests\DestroyTask;
use App\Http\Requests\ListTask;
use App\Http\Requests\ShowTask;
use App\Http\Requests\StoreTask;
use App\Http\Requests\UpdateTask;
use App\Task;

class ApiTaskController extends Controller
{
    public function index(ListTask $request)
    {
        return Task::all();
    }

    // Injeccció de depèndències
    public function store(StoreTask $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $task = Task::create([
            'name'      => $request->name,
//            'description' => $request->description,
            'description' => "hola don pepito",
            'user_id'   => $request->user_id,
            'completed' => false,
        ]);

        return $task;
    }

    public function destroy(DestroyTask $request, Task $task)
    {
        $task->delete();

        return $task;
    }

    public function update(UpdateTask $request, Task $task)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $task->name = $request->name;
        $task->save();

        return $task;
    }

    public function complete(CompleteTask $request, Task $task)
    {
        $task->update(['completed' => $task->completed ? false : true]);

        return $task;
    }

    public function show(ShowTask $request, Task $task)
    {
        return $task;
    }
}
