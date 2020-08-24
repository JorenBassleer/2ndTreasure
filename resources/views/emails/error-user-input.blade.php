@component('mail::message')
# A user has encountered a 500 error
# This is the message that the user send


<h2>Message </h2>
@component('mail::panel')

<p>{{$text}}</p>
@endcomponent

@endcomponent
