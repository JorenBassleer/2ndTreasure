var script = document.createElement('script');
script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAXVSQngRh511t5sFYqGlveekKmHBda-ow&callback=initMap';
script.defer = true;
document.head.appendChild(script);
window.initMap = function() {
    let map, infoWindow;
    var foodbankCenter = new google.maps.LatLng(foodbankLoc);
    var styledMapType = new google.maps.StyledMapType(styledMap);

    var mapOptions = {
        center: foodbankCenter,
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
    
};


function setMarkers(map){
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
        title: foodbank.name

    });
    marker.addListener("click", () => {
        infowindow.open(map, marker);
        document.getElementById("foodbank_id").value = foodbank.id;
    });   
}