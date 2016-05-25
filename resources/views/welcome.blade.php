<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
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
        height: 100%;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>

    <script type="text/javascript" src="{{ asset('js/geo.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_BROWSER_API_KEY','')}}&callback=initMapWithLocation"
	async defer></script>

		<br><br><br><hr>
		<form action="{{ url('lookup') }}" method="POST" class="form-horizontal">
			{{ csrf_field() }}
			<input type="text" name="query" id="query" class="form-control">
			<button type="submit" class="btn btn-default">POST</button>
		</form>


  </body>
</html>
