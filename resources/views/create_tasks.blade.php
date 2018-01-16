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

    <a href="/tasks_php" class="btn btn-success" role="button" aria-disabled="true"> < Back</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="box">
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
                    <label for="name">Description</label>
                    <textarea name="description" placeholder="Title" id="description"></textarea>
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
                <div class="box-footer with-border">
                    <input class="btn btn-warning" type="submit" value="Create">
                    <a href="/tasks_php" class="btn btn-success pull-right" role="button" aria-disabled="true">List Tasks</a>
                </div>
            </form>
        </div>
    </div>
@endsection