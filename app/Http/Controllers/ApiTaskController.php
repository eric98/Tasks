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
        Task::create([
           'name' => $request->name
        ]);
    }
}
