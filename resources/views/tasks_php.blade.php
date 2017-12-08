@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Tasks
@endsection

@section('main-content')
    @if (Session::get('status') )
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
            {{ Session::get('status') }}
        </div>
    @endif

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Tasks:</h3>
        </div>
        <form action="/tasks_php/create" method="GET">
            <input class="btn btn-success" type="submit" value="Create Task">
        </form>
        <div class="box-body">
            <table class="table table-bordered table-hover table-striped">
                <tbody>
                <tr>
                    <th style="width: 10px">#</th>
                    <th style="width: 10px">Id</th>
                    <th>Task</th>
                    <th style="width: 10px">User_Id</th>
                    <th style="width: 200px">Actions</th>
                </tr>

                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $task->id}}</td>
                        <td>{{ $task->name }}</td>
                        <td>{{ $task->user_id }}</td>

                        <td>
                            <form action="/tasks_php/{{ $task->id }}" method="POST">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="btn-group">
                                    <a href="/tasks_php/{{ $task->id}}" class="btn btn-info" role="button" aria-disabled="true">Show</a>
                                    <a href="/tasks_php/edit/{{ $task->id}}" class="btn btn-warning" role="button" aria-disabled="true">Edit</a>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>

    {{ Session::get('status') or '' }}
@endsection
