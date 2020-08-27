var script = document.createElement('script');
script.src = 'https://maps.googleapis.com/maps/api/js?key=' + key +'&callback=initMap';
script.defer = true;
document.head.appendChild(script);
window.initMap = function() {
    let map, infoWindow;
    var styledMapType = new google.maps.StyledMapType(styledMap);
    antwerp = new google.maps.LatLng(51.2194475,4.4024643);
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
    map = new google.maps.Map(document.getElementById('map-code'), mapOptions);
    map.mapTypes.set('styled_map', styledMapType);
    map.setMapTypeId('styled_map');
    setMarkers(map);

    // Try HTML5 geolocation.
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
        var pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
        };

        map.setCenter(pos);
        }, function() {
            // User has disabled location usage
            handleLocationError(infoWindow);
        });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(infoWindow);
    }
    
    function handleLocationError(infoWindow) {
        // Change text of btn and set hidden input to visible
        document.getElementById('btn-direction').innerHTML = "Get directions by clicking on the map and this button";
        // Create the initial InfoWindow.
        var infoWindow = new google.maps.InfoWindow(
            {content: 'Error: Geolocation failed. Click the map for a starting point and the button for directions to the foodbank!', position: antwerp});
        infoWindow.open(map);
        // Configure the click listener.
        map.addListener('click', function(mapsMouseEvent) {
            // Close the current InfoWindow.
            infoWindow.close();
            // Create a new InfoWindow.
            infoWindow = new google.maps.InfoWindow({position: mapsMouseEvent.latLng});
            infoWindow.setContent("Choose a starting point by clicking on the map and the button");
            var lat = mapsMouseEvent.latLng.lat();
            var lng = mapsMouseEvent.latLng.lng();
            // Send the value to hidden input so we can access them in calcRoute() when 
            // User clicks button
            document.getElementById("hidden-lat").value = lat.toString();
            document.getElementById("hidden-lng").value = lng.toString();
            infoWindow.open(map);
        });
    }
    
};

function calcRoute() {
    var directionsRenderer = new google.maps.DirectionsRenderer();
    var directionsService = new google.maps.DirectionsService();
    var styledMapType = new google.maps.StyledMapType(styledMap);

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
    map = new google.maps.Map(document.getElementById('map-code'), mapOptions);
    map.mapTypes.set('styled_map', styledMapType);
    map.setMapTypeId('styled_map');
    directionsRenderer.setMap(map);
    // These fields only get a value if user/browser has disabled geolocation
    var userLat = document.getElementById('hidden-lat').value;
    var userLng = document.getElementById('hidden-lng').value;
    if (userLat == "" && userLng == "") {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
                }
            var start = pos;
            var end = {lat: Number(foodbank.lat), lng: Number(foodbank.lng)};
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
        });
    }
    // User/Browser doesn't allow localisation
    else {
        // Get lat & lng from hidden inputs
        var start = {lat: Number(userLat), lng: Number(userLng)};
        var end = {lat: Number(foodbank.lat), lng: Number(foodbank.lng)};
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
}





function setMarkers(map){
    var foodbankLoc = {lat: Number(foodbank.lat), lng: Number(foodbank.lng)}
    const contentString =
        '<div id="content">' +
        '<div id="siteNotice">' +
        "</div>" +
        '<h2 id="firstHeading" class="firstHeading">'+foodbank.name+'</h2>' +
        '<div id="bodyContent">' +
        "<p>" + foodbank.name + " " + foodbank.details + "</p>" +
        '<a href="https://2ndtreasure.live/foodbank/'+ foodbank.id +'">Link</a>' +
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
    });   
}