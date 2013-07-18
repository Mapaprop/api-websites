<?php 
	include 'lib/api-website-v1.php';
	
	include 'common.php';
		
	$code = '1-434';
	$seoUrl = 'venta-de-departamento-en-floresta-capital-federal-1-10891';
	
// 	$response = $API->queryProperty($code, null);
	$response = $API->queryProperty(null, $seoUrl);
	echo $response;
?>