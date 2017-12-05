@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Tasks
@endsection


@section('main-content')


{{ Session::get('status') }}

<h1>Create Task:</h1>

<form action="/tasks" method="POST">
    {{ csrf_field() }}
    Name: <input type="text" name="name" placeholder="Title" id="name">
    User id: <textarea name="user_id" id="user_id" cols="30" rows="10" placeholder="Put your user_id here"></textarea>
    <input type="submit" value="Create">
</form>

<form action="/tasks_php" method="GET">
    <input type="submit" value="List Tasks">
</form>

@endsection