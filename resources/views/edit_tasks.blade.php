@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Tasks
@endsection


@section('main-content')
    <div class="box">
        @if (Session::get('status') )
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                {{ Session::get('status') }}
            </div>
        @endif

        <div class="box-header with-border">
            <h3 class="box-title">Edit Task:</h3>
        </div>


        <div class="form-group">
            <form action="/tasks_php/{{ $task->id }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PUT">
                <div class="box-header with-border">
                    <label for="name">Name</label>
                    <input type="text" name="name" placeholder="Put your name here" value="{{ $task->name }}" id="name">
                </div>
                <div class="box-header with-border">
                    <label for="name">User</label>
                    <select name="user_id" id="user_id" class="form-control">
                        @foreach ($users as $user)
                            @if ( $task->user_id == $user->id )
                                <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                            @else
                                <option value="{{ $user->id }}" >{{ $user->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>


                <div class="box-header with-border">
                    <button class="btn btn-warning" type="submit">Update</button>
                </div>

            </form>
            <div class="box-header with-border">
                <form action="/tasks_php" method="GET">
                    <input class="btn btn-success" type="submit" value="List Tasks">
                </form>
            </div>
        </div>
    </div>
@endsection