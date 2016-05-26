<!DOCTYPE html>
<html>
  <head>
    <title>Prepo</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{{ csrf_token() }}}">

    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 80%;
      }
    </style>
  </head>
  <body>
	<div>
		<h3>Click anywhere in North Park to see the street sweeping schedule</h3>
		<ul>TODO
			<li>add button to show current location
			<li>detect whether the current time is during the street sweeping window
			<li>display all bad parking zones for a given time
			<li>expand beyond north park
		</ul>
	</div>
    <div id="map"></div>

    <script type="text/javascript" src="js/geo.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_BROWSER_API_KEY','')}}&callback=initMap" async defer></script>

		<br><br><br><hr>
		<form action="{{ url('lookup') }}" method="POST" class="form-horizontal">
			{{ csrf_field() }}
			<input type="text" name="query" id="query" class="form-control">
			<button type="submit" class="btn btn-default">POST</button>
		</form>


  </body>
</html>
