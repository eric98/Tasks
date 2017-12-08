<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyTask;
use App\Http\Requests\ShowTask;
use App\Http\Requests\StoreTask;
use App\Http\Requests\UpdateTask;
use App\Task;
use App\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

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
        $users = User::all();

        return view('tasks_php', ['tasks' => $tasks,'users' => $users]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();

        return view('create_tasks', ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTask $request)
    {
        Task::create([
            'name' => $request->name,
            'user_id' => $request->user_id,
            'completed' => false
            ]);

        Session::flash('status', 'Created ok!');
        return Redirect::to('/tasks_php/create');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Task $task
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ShowTask $request, Task $task)
    {
        return view('show_tasks', ['task' => $task]);
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
        $users = User::all();

        return view('edit_tasks', ['task' => $task, 'users' => $users]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Task                $task
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTask $request, Task $task)
    {
        $task->update($request->only(['name','user_id']));

        Session::flash('status', 'Edited ok!');
        return Redirect::to('/tasks_php/edit/'.$task->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Task $task
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyTask $request, Task $task)
    {
        $task->delete();
        Session::flash('status', 'Task was deleted successful!');
        return Redirect::to('/tasks_php');
    }
}
