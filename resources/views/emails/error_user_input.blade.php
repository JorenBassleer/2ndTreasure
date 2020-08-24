@component('mail::message')
# A user has encountered a 500 error
# This is the message that the user send
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Fira+Sans&display=swap" rel="stylesheet">


<h2>Message </h2>
@component('mail::panel')

<p>{{$text}}</p>
@endcomponent

@endcomponent
