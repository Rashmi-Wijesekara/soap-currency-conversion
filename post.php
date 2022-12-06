<?php
require_once 'vendor/autoload.php';
$client = new nusoap_client("https://localhost/currency-conversion/server.php?wsdl");

if($_POST) {
	ini_set('display_errors', 1); 
	error_reporting(E_ALL);

	$data = $_POST['details'][0];

	$amountInSourceCurrency = $data['amountInSourceCurrency'];
	$sourceCurrency = $data['sourceCurrency'];
	$targetCurrency = $data['targetCurrency'];
	
	$response = $client->call('currency_conversion', array(
		"amountInSourceCurrency"=> $amountInSourceCurrency,
		"sourceCurrency"=> $sourceCurrency,
		"targetCurrency"=> $targetCurrency
	));

	$result = json_decode($response, true);
	
	if($result == null){
		echo "no data";
		return;
	}

	// round the float value into 6 decimal points
	echo json_encode(round($result['msg'], 6));

}
?>

