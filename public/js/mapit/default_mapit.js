$(function() {
	//Set variables
    var rendererOptions = { draggable: true }; 
    var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);;
    var directionsService = new google.maps.DirectionsService();
    var locale = "";
    var start = end = '';
    
    $('#btn_route').click(function(e) { calcRoute(); });
    $("#mapit-form").submit(function(e) { 
    	calcRoute();
    	return false; 
    });    

    //Request users location
    function initialize() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        }
    }
    
    //Calculate Route
    function calcRoute() {
       start = $('#start_location').val();
       end = $('#end_location').val();
       var request = {
    			origin: start,
    			destination: end,
    			travelMode: google.maps.TravelMode.DRIVING
    		};    	
    	directionsService.route(request, function(response, status) {
    		if (status == google.maps.DirectionsStatus.OK) {
    			directionsDisplay.setDirections(response);
    		}
    	});
    }

    //Total Distance
    function computeTotalDistance(result) {
    	var total = 0;
    	var myroute = result.routes[0];
    	for (var i = 0; i < myroute.legs.length; i++) {
    		total += myroute.legs[i].distance.value;
    	}
    	total = total / 1000.0;
    	var label = "<h4>Directions&nbsp;&nbsp;";
    	$('#total').html(label+'<span class="glyphicon glyphicon-print"></span>&nbsp;&nbsp;<span class="glyphicon glyphicon-envelope"></span></h4><br/>' + total + ' km');
    }
    
    function showPosition(position) {
    	locale = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
    	mapLocation();
    }  
    
    //
    function mapLocation() {
    	var loc = (locale!="") ? locale : new google.maps.LatLng(41.850033, -87.6500523);
    	var map;
    	var mapOptions = {
    			zoom: 7,
    			center: loc
    		};
    	map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    	directionsDisplay.setMap(map);
    	directionsDisplay.setPanel(document.getElementById('directionsPanel'));
    	google.maps.event.addListener(directionsDisplay, 'directions_changed', function() {
    		computeTotalDistance(directionsDisplay.getDirections());
    	});    	
    }    
    
    //When map ready
    google.maps.event.addDomListener(window, 'load', initialize);
});