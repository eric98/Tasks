<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();

        return view('tasks_php', ['tasks' => $tasks]);

//        $tasks = Task::all();
//        return view('tasks::list_task', compact('tasks'));
    }

    public function indexVue()
    {
        $tasks = Task::all();

        return view('tasks', ['tasks' => json_encode($tasks)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks::create_task');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        Task::create($request->only(['name','description']));
//
//        Session::flash('status', 'Created ok!');
//        return Redirect::to('/tasks_php/create');


        Task::create([
            'name' => $request->name,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Task $task
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
//        return view('tasks::show_task', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Task $task
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
//        return view('tasks::edit_task', ['task' => $task]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Task                $task
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
//        $task->update($request->only(['name','description']));
//
//        Session::flash('status', 'Edited ok!');
//        return Redirect::to('/tasks_php/edit/'.$task->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Task $task
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
//        $task->delete();
//        Session::flash('status', 'Task was deleted successful!');
//        return Redirect::to('/tasks_php');
    }
}
