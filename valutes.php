<?php
	$dbh = new PDO('mysql:host=localhost;dbname=valutes', 'root', '');

	$valutes = [];
	if(in_array("1", $argv)){
		$string = file_get_contents("http://127.0.0.1/dashboard/valutes/rates.json");
		$json_a = json_decode($string, true);
		foreach ($json_a as $curency) {
			foreach($curency as $key => $value){
				$valutes[$key] = $value;
			}
		}
	}elseif (in_array("2", $argv)) {
		$string = file_get_contents("http://127.0.0.1/dashboard/valutes/rates1.json");
		$json_a = json_decode($string, true);
		foreach ($json_a['rates'] as $curency) {
			$valutes[$curency['symbol']] = $curency['rate'];
		}
	}

	$stmt = $dbh->prepare("INSERT INTO currency (symbol, rate) VALUES (:symbol, :rate)");
	$stmt->bindParam(':symbol', $symbol);
	$stmt->bindParam(':rate', $rate);
	
	foreach ($valutes as $symbol => $rate) {
		$stmt->execute();
	}

	$dbh = null;
	echo 'Done';