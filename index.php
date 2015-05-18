<?php
	$app_key = 'xTzS6N2Jxg2PT9ht';
	$request_done = false;
	if (isset($_POST['quoi']) && !empty($_POST['quoi']) ||
	isset($_POST['categorie']) && !empty($_POST['categorie']) ||
	isset($_POST['jour']) && !empty($_POST['jour']) ||
	isset($_POST['heure']) && !empty($_POST['heure']) ||
	isset($_POST['ou']) && !empty($_POST['ou']))
	{
		// On signifie au programme qu'une reqûete a été effectuée pour qu'il ne fasse pas la requête par défaut
		$request_done = true;
		
		// Quoi?
		if (isset($_POST['quoi']) && !empty($_POST['quoi']) && $_POST['quoi'] != "Quoi?")
		{
			$quoi = urlencode($_POST['quoi']);
		} 
		else
		{
			$quoi="";
		}
		
		// Catégorie
		if (isset($_POST['categorie']) && !empty($_POST['categorie']))
		{
			$type = $_POST['categorie'];
		} 
		else
		{
			$type="music";
		}
		
		// Jour
		if (isset($_POST['jour']) && !empty($_POST['jour']))
		{
			$datedebut = new DateTime($_POST['jour']);
		} 
		else
		{
			$datedebut= new DateTime();
		}
		
		// Ou
		if (isset($_POST['ou']) && !empty($_POST['ou']) && $_POST['ou'] != "Où?")
		{
			$lieu = urlencode($_POST['ou']);
			// Google Maps Geocoder
				$geocoder = "http://maps.googleapis.com/maps/api/geocode/json?address=%s&sensor=false";

				$adresse = $_POST['ou'];
			// Requête envoyée à l'API Geocoding
				$query = sprintf($geocoder, urlencode(utf8_encode($adresse)));

				$result = json_decode(file_get_contents($query));
				$json = $result->results[0];

				$lat = (string) $json->geometry->location->lat;
				$long = (string) $json->geometry->location->lng;
				

						 

		

								
							
				
		} 
		else
		{
			$lieu="Lyon";
			// Google Maps Geocoder
				$geocoder = "http://maps.googleapis.com/maps/api/geocode/json?address=%s&sensor=false";

				$adresse="Lyon";
			// Requête envoyée à l'API Geocoding
				$query = sprintf($geocoder, urlencode(utf8_encode($adresse)));

				$result = json_decode(file_get_contents($query));
				$json = $result->results[0];

				$lat = (string) $json->geometry->location->lat;
				$long = (string) $json->geometry->location->lng;
		}
		
		/*// Heure 
		if (isset($_POST['heure']) && !empty($_POST['heure']))
		{
			$lieu = $_POST['heure'];
		} 
		else
		{
			$lieu="Lyon";
		}*/
		$request ='http://api.eventful.com/rest/events/search?app_key=xTzS6N2Jxg2PT9ht&q='.$quoi.'&category='.$type.'&l='.$lieu.'&date='.$datedebut->format('YYYYMMDD');
	
		$response = file_get_contents($request);
		$search = new SimpleXMLElement($response);
	}
	else{
		$lieu="Lyon";
			// Google Maps Geocoder
				$geocoder = "http://maps.googleapis.com/maps/api/geocode/json?address=%s&sensor=false";

				$adresse="Lyon";
			// Requête envoyée à l'API Geocoding
				$query = sprintf($geocoder, urlencode(utf8_encode($adresse)));

				$result = json_decode(file_get_contents($query));
				$json = $result->results[0];

				$lat = (string) $json->geometry->location->lat;
				$long = (string) $json->geometry->location->lng;
		
	}
?>
<!DOCTYPE html>
<html>
	<head>
	
	<!-- encoding and vievwport specification -->
	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	
	<!-- Map js functions & initialisation -->
	
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQHyZ7c97niA4qbhDscTVyHRtdv_nXJ2Y"></script>
	<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobubble/src/infobubble.js"></script>


	<!-- CSS files -->

	<link rel=stylesheet href="style.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

	</head>
  
	<body>
		<div class="container-fluid">
			<nav class="navbar navbar-inverse">
				<center>
					<form class="form-inline" method="POST" action="index.php">
						<div class="form-group">
							<input class="form-control" type="text" name="quoi" value="Quoi?" onfocus="if (this.value=='Quoi?')this.value='';">
							<select name="categorie" class="form-control">
								<?php
									// Affichage des différentes catégories proposées par l'api dans la dropdownlist
									$categories=file_get_contents("http://api.eventful.com/rest/categories/list?app_key=xTzS6N2Jxg2PT9ht");
									$categories = new SimpleXMLElement($categories);
									foreach ($categories->category as $category) {
										echo "<option value=".$category->id.">".$category->name."</option>";
									}
								?>
							</select>
							<input type="date" name="jour" class="form-control">
							<input type="time" name="heure" class="form-control">
							<input type="text" name="ou" value="Où?" class="form-control" onfocus="if (this.value=='Où?')this.value='';">>
							<button type="submit" class="btn btn-default text-center">Trouver ma soirée!</button>
						</div>
					</form>
				</center>
			</nav>
			<h1 id="titre">Évènements:</h1> 
			<div class="col-xs-4">
				<div id="infos" class="text-center">
					<?php 
						// Affichage des évènements du jour
						if ($request_done === false)
						{
							$response = file_get_contents('http://api.eventful.com/rest/events/search?app_key=xTzS6N2Jxg2PT9ht&q=music&l=Lyon&date=This%20Week');
							
							$search = new SimpleXMLElement($response);
						}
						if ($search->total_items == '0')
						{
							echo "Pas de résultats pour la recherche demandée.";
						}
						echo "<script>	var map;
								function initialize() {
									var mapOptions = {
									center: { lat: ".$lat.", lng: ".$long."},
									zoom: 12
								};
								
								map = new google.maps.Map(document.getElementById('map-canvas'),
								mapOptions);";
								$compteur=0;
								foreach ($search->events->event as $event) {
									$date = new DateTime($event->start_time);
									$date_fin = new DateTime($event->stop_time);
									$title=str_replace("'"," ",$event->title);
									$venue_name=str_replace("'"," ",$event->venue_name);
								echo "var myLatlng = new google.maps.LatLng( ".$event->latitude.",".$event->longitude.");
								var marker = new google.maps.Marker({
									position: myLatlng,
									map: map,
									title: 'Hello World!'
								});
								//Initialiser la variable qui va enregistrer la dernière infobulle ouverte
								var prev_infobulle;
								//Créer un évènement au clic sur le marker
								google.maps.event.addListener(marker, 'click', function(event) {
								 
								//Initialiser la variable dans laquelle va être construit l'objet InfoBubble
								var infobulle;
								infobulle = new InfoBubble({
								map: map,
								content: '<center><h3><a href=".$event->url.">".$title."</a></h3>".$date->format('d-m-y')."/". $date_fin->format('d-m-y')."</br>".$date->format('H:i')."</br>".$event->city_name."/".$event->country_name."</br><a href=".$event->venue_url.">".venue_name."</a></br></center>',
								position: event.latLng,  // Coordonnées latitude longitude du marker
								shadowStyle: 0,  // Style de l'ombre de l'infobulle (0, 1 ou 2)
								padding: 10,  // Marge interne de l'infobulle (en px)
								backgroundColor: 'rgb(255,255,255)',  // Couleur de fond de l'infobulle
								borderRadius: 0, // Angle d'arrondis de la bordure
								arrowSize: 10, // Taille du pointeur sous l'infobulle
								borderWidth: 3,  // Épaisseur de la bordure (en px)
								borderColor: '#009EE0', // Couleur de la bordure
								disableAutoPan: false, // Désactiver l'adaptation automatique de l'infobulle
								hideCloseButton: false, // Cacher le bouton 'Fermer'
								arrowPosition: 50,  // Position du pointeur de l'infobulle (en %)
								arrowStyle: 0,  // Type de pointeur (0, 1 ou 2)
								disableAnimation: false,  // Déactiver l'animation à l'ouverture de l'infobulle
								minWidth :   300  // Largeur minimum de l'infobulle  (en px)
								});
								 
								  //Si on a déjà une infobulle ouverte, on la ferme
								if( prev_infobulle )
								{
								prev_infobulle.close();
								}
								 
								  //La précédent infobulle devient l'infobulle que l'on va ouvrir
								prev_infobulle = infobulle;
								 
								  //Enfin, on ouvre l'infobulle
								infobulle.open();
								});
								";
								$compteur++;
								}
								echo "compteur:".$compteur;
								echo "
								}	 
							google.maps.event.addDomListener(window, 'load', initialize);</script>";
						foreach ($search->events->event as $event) {
							$date = new DateTime($event->start_time);		
							echo "<h3><a href=".$event->url.">".$event->title."</a></h3>";
							if (isset($event->stop_time) && !empty($event->stop_time))
							{
								$date_fin = new DateTime($event->stop_time);
								echo $date->format('d-m-y')."/". $date_fin->format('d-m-y')."</br>";
							}
							else
							{
								echo $date->format('d-m-y')."</br>";
							}	
							echo $date->format('H:i')."</br>";
							echo $event->city_name."/".$event->country_name."</br>";
							echo "<a href=".$event->venue_url.">".$event->venue_name."</a></br>";
							
							echo "</br></br>";
							$date_fin = "";
						}
					?>
				</div>
			</div>
			<div class="col-xs-8">
				<div id="map-canvas"/>
			</div>
		</div>
	</body>
</html>