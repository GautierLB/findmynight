
<!DOCTYPE html>
<html>
	<head>
	
	<!-- encoding and vievwport specification -->
	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	
	<!-- Map js functions & initialisation -->
	
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQHyZ7c97niA4qbhDscTVyHRtdv_nXJ2Y"></script>
	<script type="text/javascript">
	  function initialize() {
		var mapOptions = {
		  center: { lat: 48.853, lng: 2.35},
		  zoom: 8
		};
		var map = new google.maps.Map(document.getElementById('map-canvas'),
			mapOptions);
	  }
	  google.maps.event.addDomListener(window, 'load', initialize);
	</script>

	<!-- CSS files -->

	<link rel=stylesheet href="style.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

	</head>
  
	<body>
		<div class="container-fluid">
			<nav class="navbar navbar-inverse">
				<center>
					<form class="form-inline">
					   <div class="form-group">
					   
						<input class="form-control" type="text" name="quoi" value="Quoi?">
						
						<select class="form-control">
						  <option value="Soirée">Soirée</option>
						  <option value="Cinema">Cinema</option>
						  <option value="Concert">Concert</option>
						  <option value="Activité">Activité</option>
						</select>
						
						<input type="date" name="jour" class="form-control">
						<input type="time" name="heure" class="form-control">
						<input type="text" name="ou" value="Ou?" class="form-control">
							<button type="button" text-align="center" class="btn btn-default">Trouver ma soirée!</button>
				
					  </div>
					</form>
				</center>
			</nav>
			<h1 id="titre">Évènements:</h1> 
			<div class="row">
				<div class="col-xs-4" id="colone1">
					<div id="infos" class="div"></div>
				</div>
				<div class="col-xs-8" id="colone2">
					<div id="map-canvas"/>
				</div>
			</div>
		</div>
	</body>
</html>