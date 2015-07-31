{include file="partials/header.tpl"}
<style>
html, body, #map-canvas {
	height: 100%;
	margin: 0;
	padding: 0;
}
</style>


<div id="result"></div>

<div id="map" style="width: 100%; height: 400px;"></div>

<input type="checkbox" onchange="setTransports()"> Transports
<input type="checkbox" onchange="setTraffic()"> Trafic
<input type="checkbox" onchange="setBicyclingLayer()"> Pistes cyclables
<input type="checkbox" onchange="toggleBounce()"> Bounce

{literal}

<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script>
var centerpos = new google.maps.LatLng(48.8541926, 2.3574344);

var optionsGmaps = {
	center:centerpos,
	navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
	mapTypeId: google.maps.MapTypeId.ROADMAP,
	zoom: 15
};

var map = new google.maps.Map(document.getElementById("map"), optionsGmaps);

var result = {};
var marker = {};

if(navigator.geolocation) {

	function displayPosition(position) {

		result = {
			'latitude': position.coords.latitude,
			'longitude': position.coords.longitude,
			'altitude': position.coords.altitude
		}

		document.getElementById("result").innerHTML = JSON.stringify(result);

		var latlng = new google.maps.LatLng(result.latitude, result.longitude);

		marker = new google.maps.Marker({
			position: latlng,
			map: map,
			animation: google.maps.Animation.DROP,
			title: 'Vous êtes ici'
		});

		map.panTo(latlng);
	}

	function setTransports() {
  		var transitLayer = new google.maps.TransitLayer();
  		transitLayer.setMap(map);
	}

	function setTraffic() {
  		var trafficLayer = new google.maps.TrafficLayer();
  		trafficLayer.setMap(map);
	}

	function setBicyclingLayer() {
  		var bicyclingLayer = new google.maps.BicyclingLayer();
  		bicyclingLayer.setMap(map);
	}



	function toggleBounce() {
		if (marker.getAnimation() != null) {
			marker.setAnimation(null);
		} else {
			marker.setAnimation(google.maps.Animation.BOUNCE);
		}
	}

	function errorPosition(error) {

		switch(error.code) {
			case error.TIMEOUT:
				result = {'error': 'Timeout'};
			break;
			case error.PERMISSION_DENIED:
				result = {'error': 'Not granted permission'};
			break;
			case error.POSITION_UNAVAILABLE:
				result = {'error': 'Unable to find position'};
			break;
			case error.UNKNOWN_ERROR:
				result = {'error': 'Unknown error'};
			break;
		}
		document.getElementById("result").innerHTML = result;
	}

	navigator.geolocation.getCurrentPosition(displayPosition, errorPosition);

}
</script>

{/literal}

{include file="partials/footer.tpl"}