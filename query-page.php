<?php 
	include 'lib/api-website-v1.php';
	
	include 'common.php';
		
	$response = $API->queryPage('1700');
	echo $response;
?>