<?php

namespace App\Observers;

use App\Task;
use App\TaskEvent;
use App\User;
use Auth;
use Carbon\Carbon;

class TasksObserver
{
    /**
     * Listen to the Task created event.
     *
     * @param \App\Task $task
     *
     * @return void
     */
    public function created(Task $task)
    {
        if (Auth::check()) {
            $username = Auth::user()->name;
        } else {
            $username = User::findOrFail($task->user_id)->name;
        }
        TaskEvent::create([
            'time'      => Carbon::now(),
            'task_name' => $task->name,
            'user_name' => $username,
            'type'      => 'created',
        ]);
    }

    /**
     * Listen to the Task deleting event.
     *
     * @param \App\Task $task
     *
     * @return void
     */
    public function deleted(Task $task)
    {
        if (Auth::check()) {
            $username = Auth::user()->name;
        } else {
            $username = User::findOrFail($task->user_id)->name;
        }
        TaskEvent::create([
            'time'      => Carbon::now(),
            'task_name' => $task->name,
            'user_name' => $username,
            'type'      => 'deleted',
        ]);
    }

    public function retrieved(Task $task)
    {
    }

    public function updated(Task $task)
    {
        if (Auth::check()) {
            $username = Auth::user()->name;
        } else {
            $username = User::findOrFail($task->user_id)->name;
        }
        TaskEvent::create([
            'time'      => Carbon::now(),
            'task_name' => $task->name,
            'user_name' => $username,
            'type'      => 'updated',
        ]);
    }

    public function saved(Task $task)
    {
    }
}
