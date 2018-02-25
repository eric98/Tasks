<?php

namespace App\Observers;

use App\Task;
use App\TaskEvent;
use App\User;
use Carbon\Carbon;

class TaskObserver
{
    /**
     * Listen to the Task created event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function created(Task $task)
    {
        TaskEvent::create([
            'time' => Carbon::now(),
            'task_name' => $task->name,
            'user_name' => User::findOrFail($task->user_id)->name,
        ]);
    }

    /**
     * Listen to the Task deleting event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function deleted(Task $task)
    {
        //
    }

    public function retrieved(Task $task)
    {
        //
    }

    public function updated(Task $task)
    {
        //
    }

    public function saved(Task $task)
    {
        //
    }
}