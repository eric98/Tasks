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
        <div class="form-group">
            <div class="box-header with-border">
                <h3 class="box-title">Create Task:</h3>
            </div>

            <form action="/tasks_php" method="POST">
                {{ csrf_field() }}
                <div class="box-header with-border">
                    <label for="name">Name</label>
                    <input type="text" name="name" placeholder="Title" id="name">
                </div>
                <div class="box-header with-border">
                <label for="name">User</label>
                    <select name="user_id" id="user_id" class="form-control">
                        @foreach ($users as $user)
                            @if ( Auth::user()->id == $user->id )
                                <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                            @else
                                <option value="{{ $user->id }}" >{{ $user->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="box-header with-border">
                    <input class="btn btn-warning" type="submit" value="Create">
                </div>
            </form>

            <form action="/tasks_php" method="GET">
                <div class="box-header with-border">
                    <input class="btn btn-success" type="submit" value="List Tasks">
                </div>
            </form>
        </div>
    </div>

@endsection