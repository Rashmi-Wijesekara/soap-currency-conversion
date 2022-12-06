<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://cdn.tailwindcss.com"></script>
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
	<title>Currency Converter</title>
</head>

<body class="h-screen bg-gray-800">
	<div class="bg-gray-900 w-lg mb-5">
		<div class="text-gray-200 text-center font-bold text-2xl py-5">
			Currency Converter
		</div>
	</div>

	<!-- money transfer form  -->
	<div id="transferContainer" style="display: block;"
		class=" flex flex-col mx-auto max-w-lg p-12 space-y-4 text-center bg-gray-900 text-gray-100">

		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST"
			class=" space-y-10 ng-untouched ng-pristine ng-valid">
			<div class="flex flex-row items-center justify-evenly">
				<div class="">
					<label for="target" class="mt-5">
						From :
					</label>
					<input id="source" name="source" type="number" step="0.01" placeholder="1.00" class="my-4 w-[60%] rounded-b-md px-2 py-2 border border-gray-600 bg-gray-900 text-gray-100 focus:ring-indigo-400
						focus:border-indigo-400 focus:ring-2" />
				</div>
				<div class="">
					<select name="fromCurrency" id="fromCurrency" class="rounded-b-md focus:border-indigo-400 focus:ring-2 px-2 py-3 border border-gray-600 bg-gray-900 text-gray-100 focus:ring-indigo-400 my-4 w-[85%]">
						<?php 
							$currencies = file_get_contents('./data/currencies.json');
							$arr = json_decode($currencies, true);
							
							$out = "<ul>";
							foreach($arr as $id => $currency){
								$out .= "<option value='$id'>$currency</option>";
							}
							$out .= "</ul>";
							echo $out;
						?>
					</select>
				</div>
			</div>

			<div class="flex flex-row items-center justify-evenly">
				<div class="ml-5">
					<label for="target" class="mt-5">
						To :
					</label>
					<input id="target" name="target" type="text" step="0.01" placeholder="0.00" readonly class="my-4 w-[70%] rounded-b-md px-2 py-2 border border-gray-600 bg-gray-900 text-gray-100 focus:ring-indigo-400
						focus:border-indigo-400 focus:ring-2" />
				</div>
				<div class="">
					<select name="toCurrency" id="toCurrency" class="rounded-b-md focus:border-indigo-400 focus:ring-2 px-2 py-3 border border-gray-600 bg-gray-900 text-gray-100 focus:ring-indigo-400 my-4 w-[85%]" name="color" id="color">
						<?php 
							$currencies = file_get_contents('./data/currencies.json');
							$arr = json_decode($currencies, true);
							
							$out = "<ul>";
							foreach($arr as $id => $currency){
								if($id == 'USD'){
									$out .= "<option value='$id' selected>$currency</option>";
									continue;
								}
								$out .= "<option value='$id'>$currency</option>";
							}
							$out .= "</ul>";
							echo $out;
						?>
					</select>
				</div>
			</div>

			<input type="submit" name="submitTransfer" id="submitTransfer" value="Convert"
				class="cursor-pointer px-8 py-3 space-x-2 font-semibold rounded bg-indigo-400 text-gray-900">
		</form>
	</div>

	<script type="text/javascript">
		$(document).ready(function()
		{
			$('#submitTransfer').click(function(event) {
				
				var toCurrency = $("#toCurrency").val();
				var fromCurrency = $("#fromCurrency").val();
				var source = $("#source").val();
				var target = $("#target").val();

				console.log("amountInSourceCurrency = "+ source)
				console.log("sourceCurrency = "+ fromCurrency)
				console.log("targetCurrency = " + toCurrency)

				$.ajax({
					type: 'POST',
					url: 'post.php',
					data: {
						details: [{
							amountInSourceCurrency: source,
							sourceCurrency: fromCurrency,
							targetCurrency: toCurrency
						}]
					},
					success: function (res) {
						if(res == "no data"){
							console.log(res)
							return;
						}
						var result = $.parseJSON(res);
						console.log(result)
						document.getElementById("target").value = result
					}
				});
				event.preventDefault();
			})
		});
	</script>
</body>

</html>