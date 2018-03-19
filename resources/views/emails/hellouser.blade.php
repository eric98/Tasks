@component('mail::message')
# Welcome new User!!!

This is a simple task management application that will help you get things out ahead.

@component('mail::button', ['url' => config('app.url')])
Go to application!
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
