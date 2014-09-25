$(function() {
	//Set variables
    var rendererOptions = { draggable: true };
    var directionsPane = $('#directionsPanel').html();
    var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);;
    var directionsService = new google.maps.DirectionsService();
    var locale =  start = end =  good_start = good_end = '';
    var disable = true;
    var geocoder;
    var map;
    
    //When user request a route.
    $("#mapit-route-form").submit(function(e) { 
    	calcRoute();
    	return false; 
    });
    
    //When user request a location.
    $("#mapit-location-form").submit(function(e) { 
    	//codeAddress();
    	return false; 
    });
    
    //When user wants to save a route.
    $('#btn_save').click(function(e) {
    	if ( good_start != '' && good_end != '' ) {
    		$.post('mapit/ajax', function(e) {
    			console.log(e);
    			$('#btn_save').prop("disabled",true);
    		});
    	}
    });    
    
    //When user wants to save a route.
    $('#btn_geocode').click(function(e) {
    	codeAddress();
    });
    
    //Clear search form.
    $('#btn_reset').click(function(e){
    	$('#directionsPanel').html(directionsPane);
    	initialize();
    });
    
    //Request users location
    function initialize() {
    	geocoder = new google.maps.Geocoder();
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        }
    }
    
    //Calculate Route
    function calcRoute() {
       var start = $('#origin').val();
       var end   = $('#destination').val();
       switch($("#transit_mode").val()) {
           case 'DRIVING':
        	   mode = google.maps.TravelMode.DRIVING;
        	   break;
           case 'BICYCLING':
        	   mode = google.maps.TravelMode.BICYCLING;
        	   break;
           case 'TRANSIT':
        	   mode = google.maps.TravelMode.TRANSIT;
        	   break;
           case 'WALKING':
        	   mode = google.maps.TravelMode.WALKING;
        	   break;
           default:
        	   mode = google.maps.TravelMode.DRIVING;
        	   break;        	   
       }
       var request = {
    			origin: start,
    			destination: end,
    			travelMode: mode
    		};    	
    	directionsService.route(request, function(response, status) {
    		if (status == google.maps.DirectionsStatus.OK) {
    			directionsDisplay.setDirections(response);
    			good_start = start;
    			good_end = end;
    	    	disable = false;
    		} else {
    			good_start = good_end = '';
    			disable = true;
    		}
    		$('#btn_save').prop("disabled",disable);
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
    	$('#total').html('<h4>Directions&nbsp;&nbsp;<span class="glyphicon glyphicon-print"></span>&nbsp;&nbsp;<span class="glyphicon glyphicon-envelope"></span></h4>' + total + ' km');
    }
    
    //
    function showPosition(position) {
    	locale = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
    	mapLocation();
    }  
    
    //Load Map
    function mapLocation() {
    	var loc = (locale!="") ? locale : new google.maps.LatLng(41.850033, -87.6500523);
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
    
    //Geocode
    function codeAddress() {
        var address = document.getElementById('address').value;
        geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
    	            map: map,
    	            position: results[0].geometry.location
    	        });
    	    } else {
    	      alert('Geocode was not successful for the following reason: ' + status);
    	    }
        });
    }
    
    function clearOverlays() {
    	
    }
    
    //When map ready
    google.maps.event.addDomListener(window, 'load', initialize);
});