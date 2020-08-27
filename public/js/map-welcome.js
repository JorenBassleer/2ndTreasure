$(function() {
    var script = document.createElement('script');
    script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAXVSQngRh511t5sFYqGlveekKmHBda-ow&callback=initMap';
    script.defer = true;
    document.head.appendChild(script);
    var markers = [];
    window.initMap = function () {
        let map, infoWindow;
        var styledMapType = new google.maps.StyledMapType(styledMap);
        antwerp = new google.maps.LatLng(51.2194475, 4.4024643);
        var mapOptions = {
            center: antwerp,
            zoom: 9,
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
        map = new google.maps.Map(document.getElementById('map-goodiebag'), mapOptions);
        //Associate the styled map with the MapTypeId and set it to display.
        map.mapTypes.set('styled_map', styledMapType);
        map.setMapTypeId('styled_map');
        setMarkers(map);
    
        // Try HTML5 geolocation.
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                map.setCenter(pos);
            }, function () {
                handleLocationError(true, infoWindow, map.getCenter());
            });
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, map.getCenter());
        }
    
        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ?
                'Error: The Geolocation service failed.' :
                'Error: Your browser doesn\'t support geolocation.');
            infoWindow.open(map);
        }
        // Click on marker from previous request
        if(foodbankMarkerId != null) {
            google.maps.event.trigger( markers[foodbankMarkerId], 'click' );
        }
    };
    
    
    
    function setMarkers(map) {
        for (var i = 0; i < foodbanks.length; i++) {
            var foodbank = foodbanks[i];
            var foodbankLoc = {
                lat: Number(foodbank.lat),
                lng: Number(foodbank.lng)
            }
            createMarker(foodbankLoc, foodbank, map, foodbank.id);
        }
        
    }
    // Created this function to add Listener
    // If we add the eventlistener in for loop it only applies the last foodbank.id
    function createMarker(pos, foodbank, map, i) {
            markers[i] = new google.maps.Marker({
            position: pos,
            map, // google.maps.Map 
            title: foodbank.name,
        });
        const contentString =
            '<div id="content">' +
            '<div id="siteNotice">' +
            "</div>" +
            '<h2 id="firstHeading" class="firstHeading">' + foodbank.name + '</h2>' +
            '<div id="bodyContent">' +
            "<p>" + foodbank.name + " " + foodbank.details + "</p>" +
            '<a href="https://2ndtreasure.live/foodbank/' + foodbank.id + '">Link</a>' +
            "</div>" +
            "</div>";
        const infowindow = new google.maps.InfoWindow({
            content: contentString
        });
    
        google.maps.event.addListener(markers[i], 'click', function () {
            infowindow.open(map, markers[i]);
            document.getElementById("foodbank_id").value = foodbank.id;
        });
    
        return markers[i];
    }
    
})
