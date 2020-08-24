@component('mail::message')
# These users have been flagged as bad users
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Fira+Sans&display=swap" rel="stylesheet">


@component('mail::panel')
@foreach ($flaggedUsers as $flaggedUser)
    
<li>Name: {{$flaggedUser['name']}}</li>
<li>Email:<a href="mailto:{{$flaggedUser['email']}}"> {{$flaggedUser['email']}}</li></a>
<li>Address: {{$flaggedUser['address']}}</li>
<li>Postal code: {{$flaggedUser['postalcode']}}</li>
<li>City: {{$flaggedUser['city']}}</li>
<li>Province: {{$flaggedUser['province']}}</li>
<li>Country: {{$flaggedUser['country']}}</li>
<li>Phone: <a href="tel:{{$flaggedUser['phone']}}"> {{$flaggedUser['phone']}}</a></li>

@endforeach
@endcomponent
@endcomponent
