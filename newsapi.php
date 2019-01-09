<?php 

	header('Content-Type: application/json');
	$service_url = 'https://newsapi.org/v2/top-headlines?country=ng&apiKey=47fb07bd35584aa5a6016293d5b51018';
	$curl = curl_init($service_url);
	curl_setopt($curl, CURLOPT_HEADER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array("ovio-api-key: key"));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	$curl_response = curl_exec($curl);
	curl_close($curl);
	print $curl_response;
?>