<?php

namespace App\Http\Controllers;

use App\TaskEvent;

class TasksTimelineControler extends Controller
{
    public function index()
    {
        $task_events = TaskEvent::all()->reverse();

        return view('timeline', ['task_events' => $task_events]);
    }
}
