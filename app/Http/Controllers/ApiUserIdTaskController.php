<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserIdTask;
use App\Task;

class ApiUserIdTaskController extends Controller
{
    public function update(UpdateUserIdTask $request, Task $task)
    {
        $request->validate([
            'user_id' => 'required',
        ]);
        $task->user_id = $request->user_id;
        $task->save();

        return $task;
    }
}
