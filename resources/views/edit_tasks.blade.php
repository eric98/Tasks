@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Tasks
@endsection


@section('main-content')
{{ Session::get('status') }}

<h1>Edit Task:</h1>

<form action="/tasks_php/{{ $task->id }}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="PUT">
    Name: <input type="text" name="name" placeholder="Put your name here" value="{{ $task->name }}" id="name">
    User_id: <textarea name="user_id" id="user_id" cols="30" rows="10" placeholder="Put your user_id here">{{ $task->user_id }}</textarea>
    <button type="submit">Update</button>
</form>

<form action="/tasks_php" method="GET">
    <input type="submit" value="List Tasks">
</form>
@endsection