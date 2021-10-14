<?php
// Check if data was sent properly
if (isset($_GET["users"], $_GET["games"], $_GET["key"])) {
    $users = $_GET["users"];
    $games = $_GET["games"];
    $steam_key = $_GET["key"];
} elseif (isset($_POST["users"], $_POST["games"], $_POST["key"])) {
    $users = $_POST["users"];
    $games = $_POST["games"];
    $steam_key = $_POST["key"];
} else {
    echo "Error: variables not supplied. Data can be sent through POST or GET, but must include both \"users\" and \"games\" as arrays, and \"key\" as a string.";
    return;
}

// Check if data is of correct type
if (!is_array($users) || !is_array($games) || !is_string($steam_key)) {
    echo "Error: variables not correctly typed. Both \"users\" and \"games\" mst be arrays, and \"key\" must be a string.";
    return;
}

// Format URI for games in $games
$gamesUrl = "";    // Steam API compatible URI for games selected
for ($i = 0, $iMax = count($games); $i < $iMax; $i++) {
    $gamesUrl .= "&appids_filter[$i]=" . $games[$i];
}

// Check stats for each player in $users
$total_minutes = 0;// Total minutes played
foreach ($users as $u) {
    $data = json_decode(file_get_contents("http://api.steampowered.com/IPlayerService/GetOwnedGames/v1/?key=$steam_key&steamid=$u&format=json" . $gamesUrl), true);
    if (isset($data['response']['games'])) {
        foreach ($data['response']['games'] as $game) {
            $total_minutes += $game['playtime_forever'];
        }
    }
}

// Returns total
echo (int)$total_minutes;
return;

// Made by Cole Crouter, check my GitHub: https://github.com/Mexican-Man