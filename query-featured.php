<?php 
	include 'lib/api-website-v1.php';
	include 'common.php';	
	$response = $API->queryFeatured();
	echo $response;
?>