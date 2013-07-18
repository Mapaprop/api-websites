<?php 
	include 'lib/api-website-v1.php';
	include 'common.php';
	
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