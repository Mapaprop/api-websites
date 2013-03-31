<?php 
 	error_reporting(E_ALL);
	include 'lib/api-website-v1.php';
	
	define('MAPAPROP_TOKEN', 'HcrpQAYQWdnx13CGmzhl3uvHZqb9Pfe2hIu3F4lgUR4lZjOLObfFEJyLvwyjruphuDNLHPUSq4i5RyCMsoz5u1MhM81u64LYkKec');
	$API = new MapapropAPI();
	
	$operation = 1;
	$type = 1;
	$zone1 = 1;
	$zone2 = null;
	$zone3 = null;
	$priceFrom = null;
	$priceTo = null;
	$page = 1;
	$currency = null;
	$response = $API->search($zone1, $zone2, $zone3,$priceFrom, $priceTo, $currency, $operation, $type, $page);
	echo $response;
?>