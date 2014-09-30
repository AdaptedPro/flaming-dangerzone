$(function() {
    //Set variables
    var rendererOptions = { draggable: true };
    var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
    var directionsService = new google.maps.DirectionsService();
    var locale = start = end =  good_start = good_end = '';
    var disable = true;
    var geocoder;
    var map;
    var markers = [];
    
    //Init alerts wiht style
    $(".alert").alert();
     
    //When user request a route.
    $("#mapit-route-form").submit(function(e) {
    	$("#btn_reset2").trigger( "click" );
    	calcRoute();
    	return false; 
    });
    
    //When user request a location.
    $("#mapit-location-form").submit(function(e) {
    	$("#btn_reset").trigger( "click" );
    	clearDirectionsOverlay();
    	codeAddress();
    	return false; 
    });

    //When user wants to save a route.    
    $('#save_route').click(function(e) {
    	if ( good_start != '' && good_end != '' ) {
    		$('#saveRouteModal').modal('hide');
    		$('#saved_item').html('route');
    		$('#route_name').html('');
    		$.post('mapit/ajaxSaveRoute', $('.mapit-search').serialize()).done(function(msg) {    			
    			$('#success_alert').fadeOut();
    			$('#btn_save').prop("disabled",true);
    			if ($('#saved_routes').length > 0) {
    				$('#saved_routes').html(msg.routes);
    		    } else {
    		    	
    		    }
    		});
    	}    	
    });
    
    //Toggle saved rout list
    $('#saved_route_list_link').click(function(e) {
    	if (save_list_open == false) {    		
    		$('#saved_routes_lists').slideDown();
    		save_list_open = true;
    	} else {
    		$('#saved_routes_lists').slideUp();
    		save_list_open = false;
    	}
    });   
    
    //When user wants to save a route.
    $('#btn_geocode').click(function(e) {
    	codeAddress();
    });
    
    //Clear search form.
    $('#btn_reset').click(function(e){
    	$('#directionsPanel').html('');
    	clearDirectionsOverlay();
    });
    
    $('#btn_reset2').click(function(e) {
        //Clearing markers
    	$('#directionsPanel').html('');
        google.maps.Map.prototype.clearOverlays = function() {
        	for (var i = 0; i < markers.length; i++ ) {
        		markers[i].setMap(null);
            }
            markers.length = 0;
        }    	
    });
    
    //When user selects a route from list
    $('#saved_routes').change(function(e) {
    	$.get('mapit/ajaxGetRoute/'+$(this).val(), function(m) {
    		$('#origin').val(m.success['origin']);
    		$('#destination').val(m.success['destination']);
    		$("#travel_mode").val(m.success['travel_mode']);
    	});
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
       switch($("#travel_mode").val()) {
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
       var request = { origin: start, destination: end, travelMode: mode };
       directionsService.route(request, function(response, status) {
    		if (status == google.maps.DirectionsStatus.OK) {
    			directionsDisplay.setDirections(response);
    			good_start = start;
    			good_end = end;
        		//disable = $('#id').val() > 0 ? true : false;
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
    
    //Center map relative to user
    function showPosition(position) {
    	locale = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
    	mapLocation();
    }  
    
    //Load Map
    function mapLocation() {
    	var loc = (locale!="") ? locale : new google.maps.LatLng(41.850033, -87.6500523);
    	var mapOptions = { zoom: 7, center: loc };
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
                var marker = new google.maps.Marker({ map: map, position: results[0].geometry.location });
                markers.push(marker);
    	    } else {
    	      alert('Geocode was not successful for the following reason: ' + status);
    	    }
        });
    }
    
    //Clear driving directions
    function clearDirectionsOverlay() {
    	var rendererOptions = { map: map };
    	if(directionsDisplay != null) {
    	    directionsDisplay.setMap(null);
    	    directionsDisplay = null;
    	}
    	directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
    	directionsDisplay.setMap(map);
    	directionsDisplay.setPanel(document.getElementById("directionsPanel"));
    	$('#directionsPanel').html('');
    }
        
    //When map ready
    google.maps.event.addDomListener(window, 'load', initialize);
});
