<?php
	$app_key = 'xTzS6N2Jxg2PT9ht';
	$response = file_get_contents('http://api.eventful.com/rest/events/search?app_key=xTzS6N2Jxg2PT9ht&q=bite&l=San+Diego&date=This%20Week');
	$search = new SimpleXMLElement($response);
	foreach ($search->events->event as $event) {
		$date = new DateTime($event->start_time);		
   		echo "<a href=".$event->url.">".$event->title."</a></br>";
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
		echo $event->olson_path."</br>";
		echo "<a href=".$event->venue_url.">".$event->venue_name."</a></br>";
		echo $event->latitude;
		echo $event->longitude;
		echo "</br></br>";
		$date_fin = "";
	}
	$categories=file_get_contents("http://api.eventful.com/rest/categories/list?app_key=xTzS6N2Jxg2PT9ht");
	$categories = new SimpleXMLElement($categories);
	foreach ($categories->category as $category) {
   		echo $category->id."</br>";
	}
	$quoi="music";
	$type="music";
	$datedebut= new DateTime();
	$lieu="Lyon";
	$response = file_get_contents('http://api.eventful.com/rest/events/search?app_key=xTzS6N2Jxg2PT9ht&q='.$quoi.'&category='.$type.'&l='.$lieu.'&date='.$datedebut->format('YYYYMMDD'));
	$search = new SimpleXMLElement($response);
	foreach ($search->events->event as $event) {
		$date = new DateTime($event->start_time);		
   		echo "<a href=".$event->url.">".$event->title."</a></br>";
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
		echo $event->olson_path."</br>";
		echo "<a href=".$event->venue_url.">".$event->venue_name."</a></br>";
		echo "</br></br>";
		$date_fin = "";
	}

?>