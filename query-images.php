<?php 
	include 'lib/api-website-v1.php';
	
	include 'common.php';
		
	$response = $API->queryImages('1-434');
	echo $response;
?>