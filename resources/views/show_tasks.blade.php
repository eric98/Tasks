@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Tasks
@endsection


@section('main-content')
    <h1>Task:</h1>

    <ul>
        <li>Name: {{ $task->name }}</li>
        <li>User_id: {{ $task->user_id }}</li>
    </ul>

    <form action="/tasks_php" method="GET">
        <input type="submit" value="List Tasks">
    </form>
@endsection