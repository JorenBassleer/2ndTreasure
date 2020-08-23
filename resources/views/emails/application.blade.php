@component('mail::message')
# Application for foodbank


<h2>Information given: </h2>
<ul>
    <li>Name: {{$foodbankInformation['foodbank_name']}}</li>
    <li>Email:<a href="mailto:{{$foodbankInformation['foodbank_email']}}"> {{$foodbankInformation['foodbank_email']}}</li></a>
    <li>Address: {{$foodbankInformation['foodbank_address']}}</li>
    <li>Postal code: {{$foodbankInformation['foodbank_postalcode']}}</li>
    <li>City: {{$foodbankInformation['foodbank_city']}}</li>
    <li>Province: {{$foodbankInformation['foodbank_province']}}</li>
    <li>Country: {{$foodbankInformation['foodbank_country']}}</li>
    <li>Phone: <a href="tel:{{$foodbankInformation['foodbank_phone']}}"> {{$foodbankInformation['foodbank_phone']}}</a></li>
</ul>
@endcomponent
