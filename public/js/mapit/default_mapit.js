$(function() {
    var rendererOptions = { draggable: true }; 
    var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);;
    var directionsService = new google.maps.DirectionsService();
    var locale = new google.maps.LatLng(41.850033, -87.6500523);
    var start = end = '';
    var map;
    
    $("#mapit_form").submit(function(e) { calcRoute(); });    
    $('#btn_route').click(function(e) { calcRoute(); });
    
    //Map Setup
    function initialize() {
    	var mapOptions = {
    			zoom: 7,
    			center: locale
    		};
    	
    	map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    	directionsDisplay.setMap(map);
    	directionsDisplay.setPanel(document.getElementById('directionsPanel'));

    	google.maps.event.addListener(directionsDisplay, 'directions_changed', function() {
    		computeTotalDistance(directionsDisplay.getDirections());
    	});
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
    	$('#total').html(total + ' km');
    }
    
    google.maps.event.addDomListener(window, 'load', initialize);
});