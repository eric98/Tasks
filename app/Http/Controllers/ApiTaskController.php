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

        Task::create([
            'name' => $request->name
        ]);

    }

    public function destroy(Request $request, Task $task)
    {
        $task->delete();
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $task->name = $request->name;
        $task->save();
    }

    public function show(Task $task)
    {
        return $task;
    }
}
