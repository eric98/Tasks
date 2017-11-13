<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class ApiTaskController extends Controller
{
    public function index()
    {
        return Task::all();
    }

    // Injeccció de depèndències
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $task = Task::create([
            'name' => $request->name
        ]);

        return $task;

    }

    public function destroy(Request $request, Task $task)
    {
        $task->delete();
        return $task;
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $task->name = $request->name;
        $task->save();
        return $task;
    }

    public function show(Task $task)
    {
        return $task;
    }
}
