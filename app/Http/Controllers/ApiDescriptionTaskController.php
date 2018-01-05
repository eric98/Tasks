<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDescriptionTask;
use App\Task;

class ApiDescriptionTaskController extends Controller
{
    public function update(UpdateDescriptionTask $request, Task $task)
    {
        $request->validate([
            'description' => 'required',
        ]);
        $task->description = $request->description;
        $task->save();
        return $task;
    }
}
