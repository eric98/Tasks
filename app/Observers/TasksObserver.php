<?php

namespace App\Observers;

use App\Task;
use App\TaskEvent;
use App\User;
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
        TaskEvent::create([
            'time'      => Carbon::now(),
            'task_name' => $task->name,
            'user_name' => User::findOrFail($task->user_id)->name,
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
        TaskEvent::create([
            'time'      => Carbon::now(),
            'task_name' => $task->name,
            'user_name' => User::findOrFail($task->user_id)->name,
            'type'      => 'deleted',
        ]);
    }

    public function retrieved(Task $task)
    {
        TaskEvent::create([
            'time'      => Carbon::now(),
            'task_name' => $task->name,
            'user_name' => User::findOrFail($task->user_id)->name,
            'type'      => 'retrieved',
        ]);
    }

    public function updated(Task $task)
    {
        TaskEvent::create([
            'time'      => Carbon::now(),
            'task_name' => $task->name,
            'user_name' => User::findOrFail($task->user_id)->name,
            'type'      => 'updated',
        ]);
    }

    public function saved(Task $task)
    {
        TaskEvent::create([
            'time'      => Carbon::now(),
            'task_name' => $task->name,
            'user_name' => User::findOrFail($task->user_id)->name,
            'type'      => 'saved',
        ]);
    }
}
