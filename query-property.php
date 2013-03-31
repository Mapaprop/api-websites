<?php 
 	error_reporting(E_ALL);
	include 'lib/api-website-v1.php';
	
	define('MAPAPROP_TOKEN', 'HcrpQAYQWdnx13CGmzhl3uvHZqb9Pfe2hIu3F4lgUR4lZjOLObfFEJyLvwyjruphuDNLHPUSq4i5RyCMsoz5u1MhM81u64LYkKec');
	$API = new MapapropAPI();
	
	$code = '1-434';
	$seoUrl = 'venta-de-departamento-en-floresta-capital-federal-1-10891';
	
// 	$response = $API->queryProperty($code, null);
	$response = $API->queryProperty(null, $seoUrl);
	echo $response;
?>