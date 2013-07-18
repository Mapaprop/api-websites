<?php 
	include 'lib/api-website-v1.php';

	include 'common.php';
	
	$response = $API->submitQuestion('1-434', 'Raul Alamar', 'raul.alamar@gmail.com', '838-1282-3322', 'Me interesa esta propiedad');
	echo $response;
?>