<?php 
	include 'lib/api-website-v1.php';

	include 'common.php';
	
	$response = $API->queryPages();
	echo $response;
?>