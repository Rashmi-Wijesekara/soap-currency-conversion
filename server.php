<?php
	require_once 'vendor/autoload.php';
	require('./currency-conversion-service.php');

	$server = new nusoap_server();
	$server-> configureWSDL("Currency Conversion", "urn:currencyconversion");
	
	$server-> register(
		"currency_conversion", //service name
		array(
			"amountInSourceCurrency"=> "xsd:float", 
			"sourceCurrency"=> "xsd:string", 
			"targetCurrency"=> "xsd:string"
		), //inputs
		array("amountInTargetCurrency"=> "xsd:string") //output
	);

	$server->service(file_get_contents("php://input"));