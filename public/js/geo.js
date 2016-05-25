var map;
var markers = [];

function lookupSchedule(number, street, callback) {
	// do ajax
	var formdata = new FormData();
	formdata.append("number", number);
	formdata.append("street", street);

	var xhr = new XMLHttpRequest();
	xhr.open('POST', '/lookup');

	// set csrf token from page meta
	var metas = document.getElementsByTagName('meta');

	for (i=0; i<metas.length; i++) {
		if (metas[i].getAttribute("name") == "csrf-token") {
			xhr.setRequestHeader("X-CSRF-Token", metas[i].getAttribute("content"));
		}
	}

	xhr.send(formdata);

	xhr.onreadystatechange = function () {
		var DONE = 4; // readyState 4 means the request is done.
		var OK = 200; // status 200 is a successful return.
		if (xhr.readyState === DONE) {
			if (xhr.status === OK) {
				//run callback
				callback(JSON.parse(xhr.responseText)); //JSONify then callback
			}
			else {
				console.log('Error: ' + xhr.status); // An error occurred during the request.
			}
		}
	};
}

function clearMarkers() {
	for (var i = 0; i < markers.length; i++ ) {
		markers[i].setMap(null);
	}
	markers.length = 0;
}

function initMap() {
console.log('debug1');
	console.log('initmap');
	map = new google.maps.Map(document.getElementById("map"), {
		zoom: 15,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});

	// center on North Park
	map.setCenter(new google.maps.LatLng(32.75176633003113, -117.13442802429199));
console.log('debug2');
	google.maps.event.addListener(map, 'click', function(event) {

console.log('debug3');
		var latlng = event.latLng;
		console.log(latlng.toString());

		//clear all markers
		clearMarkers();

		//add a marker
		var marker = new google.maps.Marker({
			position: latlng,
			map: map
		});

		markers.push(marker);

		//reverse geocode
		var geocoder = new google.maps.Geocoder;
		geocoder.geocode({'location': latlng}, function(results, status) {
			if (status === google.maps.GeocoderStatus.OK) {
				if (results[0]) {
					// we got a street address, so add a marker for it
					console.log(results[0]);
					var address = results[0].formatted_address;
					var number = results[0].address_components[0].long_name;
					var street = results[0].address_components[1].short_name;

					//add an info window
					var infowindow = new google.maps.InfoWindow;
					infowindow.setContent(address);
					infowindow.open(map, marker);

					lookupSchedule(number, street, function(text) {
						console.log("I'm in your callback!");
						infowindow.setContent("<h3>Address</h3>" + address + "<h3>Street Sweeping Schedule</h3>" + text.schedule);
					});
				}
			}
		});
	});

console.log('debug4');
}

/**
function initMapWithLocation() {
	var initialLocation;
	var siberia = new google.maps.LatLng(60, 105);
	var newyork = new google.maps.LatLng(40.69847032728747, -73.9514422416687);
	var browserSupportFlag =  new Boolean();

	var myOptions = {
		zoom: 6,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};

	map = new google.maps.Map(document.getElementById("map"), myOptions);

	// Try W3C Geolocation (Preferred)
	if (navigator.geolocation) {
		browserSupportFlag = true;

		navigator.geolocation.getCurrentPosition(function (position) {
			// set map center
			initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
			map.setCenter(initialLocation);
			map.setZoom(17);

			// reverse geocoding (address lookup)
			var geocoder = new google.maps.Geocoder;
			var infowindow = new google.maps.InfoWindow;

			geocodeLatLng(geocoder, map, infowindow, initialLocation);
			//{lat: position.coords.latitude, lng: position.coords.longitude});

			// set query form element
			var latlong = position.coords.latitude + ', ' + position.coords.longitude;
			var query = document.getElementById('query');
			query.value = latlong;

		}, function() {
			handleNoGeolocation(browserSupportFlag);
		});
	}
	// Browser doesn't support Geolocation
	else {
		browserSupportFlag = false;
		handleNoGeolocation(browserSupportFlag);
	}
}

function handleNoGeolocation(errorFlag) {
	if (errorFlag == true) {
		alert("Geolocation service failed.");
		initialLocation = newyork;
	} else {
		alert("Your browser doesn't support geolocation. We've placed you in Siberia.");
		initialLocation = siberia;
	}
	map.setCenter(initialLocation);
}

function geocodeLatLng(geocoder, map, infowindow, latlng) {
	geocoder.geocode({'location': latlng}, function(results, status) {
		if (status === google.maps.GeocoderStatus.OK) {
			if (results[0]) {
				// we got a street address, so add a marker for it
				console.log(results[0]);
				var address = results[0].formatted_address;
				var number = results[0].address_components[0].long_name;
				var street = results[0].address_components[1].short_name;

				var marker = new google.maps.Marker({
					position: latlng,
					map: map
				});

				infowindow.setContent(address);
				infowindow.open(map, marker);

				// do ajax
				var formdata = new FormData();
				formdata.append("number", number);
				formdata.append("street", street);

				var xhr = new XMLHttpRequest();
				xhr.open('POST', '/lookup');

				// set csrf token from page meta
				var metas = document.getElementsByTagName('meta');

				for (i=0; i<metas.length; i++) {
					if (metas[i].getAttribute("name") == "csrf-token") {
						xhr.setRequestHeader("X-CSRF-Token", metas[i].getAttribute("content"));
					}
				}

				xhr.send(formdata);

				xhr.onreadystatechange = function () {
					var DONE = 4; // readyState 4 means the request is done.
					var OK = 200; // status 200 is a successful return.
					if (xhr.readyState === DONE) {
						if (xhr.status === OK) {
							console.log(xhr.responseText); // 'This is the returned text.'
						}
						else {
							console.log('Error: ' + xhr.status); // An error occurred during the request.
						}
					}
				};
			}
			else {
				window.alert('No results found');
			}
		}
		else {
			window.alert('Geocoder failed due to: ' + status);
		}
	});
}
**/

