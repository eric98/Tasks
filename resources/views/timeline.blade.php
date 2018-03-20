@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Timeline Tasques
@endsection


@section('main-content')
    <ul class="timeline">
        <li class="time-label">
            <span class="bg-red">
                {{ $actualDate = date('j F, Y', strtotime($task_events->first()->time))}}
            </span>
        </li>
        @foreach($task_events as $event)
            @if(date('j F, Y', strtotime($event->time)) != $actualDate )
                <li class="time-label">
                  <span class="bg-red">
                    {{ $actualDate = date('j F, Y', strtotime($event->time)) }}
                  </span>
                </li>
            @endif
            <li>
                <i class="fa fa-envelope bg-blue"></i>
                <div class="timeline-item">
                    <span class="time"><i class="fa fa-clock-o"></i>{{date('G:i', strtotime($event->time))}}</span>

                    <h3 class="timeline-header">{{$event->task_name}}, owned by {{$event->user_name}}</h3>

                    <div class="timeline-body">
                        User <b>{{ $event->user_name }}</b> {{ $event->type }} task <b>{{ $event->task_name }}</b> at <b>{{date('F j, Y, g:i a', strtotime($event->time))}}</b>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
@endsection