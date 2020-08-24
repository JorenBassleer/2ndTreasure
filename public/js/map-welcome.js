
var script = document.createElement('script');
script.src = 'https://maps.googleapis.com/maps/api/js?key='+ key + '&callback=initMap';
script.defer = true;
document.head.appendChild(script);


window.initMap = function() {
    let map, infoWindow;
    var styledMapType = new google.maps.StyledMapType(styledMap);
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
    map = new google.maps.Map(document.getElementById('map-goodiebag'), mapOptions);
    //Associate the styled map with the MapTypeId and set it to display.
    map.mapTypes.set('styled_map', styledMapType);
    map.setMapTypeId('styled_map');
    setMarkers(map);
    
    google.maps.event.addDomListener(window, "resize", function() {
        var center = map.getCenter();
        google.maps.event.trigger(map, "resize");
        map.setCenter(center); 
      });


    // Try HTML5 geolocation.
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
        var pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
        };

        infoWindow.setPosition(pos);
        infoWindow.setContent('You are in this area');
        infoWindow.open(map);
        map.setCenter(pos);
        }, function() {
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
    
};



function setMarkers(map){
    for (var i = 0; i < foodbanks.length; i++) {
        var foodbank = foodbanks[i];
        var foodbankLoc = {lat: Number(foodbank.lat), lng: Number(foodbank.lng)}
        createMarker(foodbankLoc,foodbank, map);
    }    
}
// Created this function to add Listener
// If we add the eventlistener in for loop it only applies the last foodbank.id
function createMarker(pos, foodbank, map) {
    var iconBase = '../images/';
    var marker = new google.maps.Marker({       
        position: pos, 
        map,  // google.maps.Map 
        title: foodbank.name,
        // icon: iconBase + 'test.png',    
    }); 
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

    google.maps.event.addListener(marker, 'click', function() { 
        infowindow.open(map, marker);
        document.getElementById("foodbank_id").value = foodbank.id;
    }); 
    return marker; 
}
