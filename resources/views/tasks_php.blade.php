@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Tasks
@endsection

@section('main-content')
    <h1>Tasques:</h1>

    @foreach ($tasks as $task)
        <ul>
            <li>Title: {{ $task->name }}</li>
        </ul>
    @endforeach
@endsection
