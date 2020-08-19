var script = document.createElement('script');
script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAXVSQngRh511t5sFYqGlveekKmHBda-ow&callback=initMap';
script.defer = true;
document.head.appendChild(script);
window.initMap = function() {
    let map, infoWindow;
    var directionsService = new google.maps.DirectionsService();
    var directionsRenderer = new google.maps.DirectionsRenderer();
    antwerp = new google.maps.LatLng(antLat, antLng);
    var mapOptions = {
        center: antwerp,
        zoom: 13,
        mapTypeControlOptions: {
        mapTypeIds: []
        }, // here´s the array of controls
        disableDefaultUI: true, // a way to quickly hide all controls
        mapTypeControl: true,
        scaleControl: true,
        zoomControl: true,
        zoomControlOptions: {
        style: google.maps.ZoomControlStyle.LARGE 
        },
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    infoWindow = new google.maps.InfoWindow;
    map = new google.maps.Map(document.getElementById('map'), mapOptions);
    setMarkers(map);
    directionsRenderer.setMap(map);


    // Try HTML5 geolocation.
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
        var pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
        };

        infoWindow.setPosition(pos);
        infoWindow.setContent('You are here');
        infoWindow.open(map);
        map.setCenter(pos);
        }, function() {
        handleLocationError(true, infoWindow, map.getCenter());
        });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }

    
};

function calcRoute() {
        var start = document.getElementById('start').value;
        var end = document.getElementById('end').value;
        var request = {
            origin: start,
            destination: end,
            travelMode: 'DRIVING'
        };
        directionsService.route(request, function(result, status) {
            if (status == 'OK') {
            directionsRenderer.setDirections(result);
            }
        });
    }


function handleLocationError(browserHasGeolocation, infoWindow, pos) {
infoWindow.setPosition(pos);
infoWindow.setContent(browserHasGeolocation ?
                        'Error: The Geolocation service failed.' :
                        'Error: Your browser doesn\'t support geolocation.');
infoWindow.open(map);
}


function setMarkers(map){
    console.log(foodbanks);
    for (var i = 0; i < foodbanks.length; i++) {
        var foodbank = foodbanks[i];
        var foodbankLoc = {lat: Number(foodbank.lat), lng: Number(foodbank.lng)}
        const contentString =
            '<div id="content">' +
            '<div id="siteNotice">' +
            "</div>" +
            '<h2 id="firstHeading" class="firstHeading">'+foodbank.name+'</h2>' +
            '<div id="bodyContent">' +
            "<p>" + foodbank.name + " " + foodbank.details + "</p>" +
            '<a href="http://127.0.0.1:8000/foodbank/'+ foodbank.id +'">Link</a>' +
            "</div>" +
            "</div>";
        const infowindow = new google.maps.InfoWindow({
            content: contentString
        });
        const marker = new google.maps.Marker({
            position: foodbankLoc,
            map,
            title: foodbank.name,
        });
        marker.addListener("click", () => {
            infowindow.open(map, marker);
            console.log(foodbank.id);
            document.getElementById("foodbank_id").value = foodbank.id;
        });
    }    
}