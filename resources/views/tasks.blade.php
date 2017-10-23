@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Tasks
@endsection


@section('main-content')
    <tasks data-tasks="{{ $tasks }}"></tasks>

    <message title="Message" message="{{ $message or '' }}" color="info"></message>
    {{--<message title="Message" message="Missatge en espais"></message>--}}

    {{--<message title="Error"></message>--}}

    {{--<message title="Error" message="Error ha petat tot!"></message>--}}

    {{--<message message="Error ha petat tot!"></message>--}}

    {{--<message></message>--}}

    {{--<message title="Error">Error ha petat tot!</message>--}}

    {{--<message title="Error" message="Error ha petat tot!"></message>--}}

    {{--<message>--}}
    {{--<slot name="title">Error</slot>--}}
    {{--<slot name="message">Error ha petat tot</slot>--}}
    {{--</message>--}}

@endsection
