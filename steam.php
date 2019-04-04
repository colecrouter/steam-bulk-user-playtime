<?php
$users; 		// Array of Steam user IDS
$games; 		// Array of Steam game IDs
$key; 			// Steam API key
$gamesUrl = "";	// Steam API compatible URI for games selected
$total = 0; 	// Total minutes played

// Check if data was sent properly
if (isset($_GET["users"], $_GET["games"], $_GET["key"])) {
	$users = $_GET["users"];
	$games = $_GET["games"];
	$key = $_GET["key"];
}
elseif (isset($_POST["users"], $_POST["games"], $_POST["key"])) {
	$users = $_POST["users"];
	$games = $_POST["games"];
	$key = $_POST["key"];
}
else {
	echo "Error: variables not supplied. Data can be sent through POST or GET, but must include both \"users\" and \"games\" as arrays, and \"key\" as a string.";
	return;
}

// Check if data is of correct type
if (gettype($users) != "array" || gettype($games) != "array" || gettype($key) != "string") {
	echo "Error: variables not correctly typed. Both \"users\" and \"games\" mst be arrays, and \"key\" must be a string.";
	return;
}

// Format URI for games in $games
for ($i = 0; $i < sizeof($games); $i++) {
	$gamesUrl .= "&appids_filter[".$i."]=".$games[$i];
}

// Check stats for each player in $users
if (isset($data['response']['games'])) {
	foreach ($users as &$no) {
		$ch = curl_init('http://api.steampowered.com/IPlayerService/GetOwnedGames/v1/?key=' . $key .'&steamid=' . $no . '&format=json' . $gamesUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = json_decode(curl_exec($ch), true);
		foreach ($data['response']['games'] as $game) {
			$total += $game['playtime_forever'];
		}
		curl_close($ch);
	}
}


// Returns total
echo $total;
return;

// Made by Cole Crouter, check my GitHub: https://github.com/Mexican-Man
?>
