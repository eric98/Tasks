@extends('adminlte::layouts.app')

@section('htmlheader_title')
	Timeline Tasques
@endsection


@section('main-content')
	<ul class="timeline">
		@foreach($task_events as $event)
		<li class="time-label">
        <span class="bg-red">
            {{date('j F, Y', strtotime($event->time))}}
        </span>
		</li>
		<li>
			<i class="fa fa-envelope bg-blue"></i>
			<div class="timeline-item">
				<span class="time"><i class="fa fa-clock-o"></i>{{date('G:i', strtotime($event->time))}}</span>

				<h3 class="timeline-header">Task name: <a href="/tasks_php/{{$event->id}}">{{ $event->task_name }}</a></h3>

				<div class="timeline-body">
					Task <b>{{ $event->task_name }}</b> was created <b>{{date('F j, Y, g:i a', strtotime($event->time))}}</b>, and is owned by <b>{{ $event->user_name }}</b></b>.
				</div>

				{{--<div class="timeline-footer">--}}
					{{--<a class="btn btn-primary btn-xs">...</a>--}}
				{{--</div>--}}
			</div>
		</li>
		@endforeach
	</ul>
@endsection