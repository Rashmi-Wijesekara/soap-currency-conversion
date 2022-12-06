<?php

function currency_conversion($amountInSourceCurrency, $sourceCurrency, $targetCurrency) {
	include('./data/rates.php');
	$amountInTargetCurrency = 0.0;

	if($sourceCurrency == "USD"){
		// convert USD into other currency
		$amountInTargetCurrency = $ratesList[$targetCurrency] * $amountInSourceCurrency;
	}
	else if($targetCurrency == "USD"){
		// convert other currency into USD
		$amountInTargetCurrency = (1/ $ratesList[$sourceCurrency]) * $amountInSourceCurrency;
	}
	else if($sourceCurrency != "USD" && $targetCurrency != "USD") {
		// conversion between 2 other currencies
		$amountInUSD = $ratesList[$sourceCurrency] * $amountInSourceCurrency;
		$amountInTargetCurrency = $ratesList[$targetCurrency] * $amountInUSD;
	}

	$arr['msg'] = $amountInTargetCurrency;
	return json_encode($arr);
}