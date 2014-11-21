<?PHP

if ($_GET['color'] == ''){
  $_GET['color'] = 'white';
}

?>


<html>

<head>
<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
<b><i><font color="<?PHP echo $_GET['color']; ?>"><font size=9><center>Only you can hear me, Summoner.</center></font>
<script src="script.js"></script>


<form action="index.php" method="post">
	Name:
	<br>
	<input type="text" name="name">
	<br>
	<input type="submit" value="submit">
</form>

Hello
<?php
if ($_POST["name"] ==''){
	echo "Summoner";
} else {
	echo $_POST["name"];
}


?>
<br><Br><br>
<pre>
<?PHP


require 'championlist.php';

#print_r($champions);
	

require 'vendor/autoload.php';
use LeagueWrap\Api;

$api = new Api('3c89c9d9-6196-463b-9c7b-2ef2f83540f8');

$summonerAPI = $api->summoner();
$gameAPI = $api->game();

$name = $_POST['name'];

$summoner = $summonerAPI->info($name);

$recentGames = $gameAPI->recent($summoner->id);

function fixlolnum($lolnumber) {
	if ($lolnumber == ''){
	  echo "0";
	} else {
	  echo $lolnumber;
	}
}


function fixlolname($lolname) {
	$lolname = str_replace(" ", "", $lolname);
	$lolname = str_replace("'", "", $lolname);
	return $lolname;
}


foreach ($recentGames->games as $gameNum => $game) {

	$championId = $game->championId;
	
	$championName = $champions[$championId];

	echo "<img src='/images/" . fixlolname($championName) . "Square.png'>";	

	echo $championName;

	echo " - ";

	fixlolnum($game->stats->championsKilled);
	echo "/";
	fixlolnum($game->stats->numDeaths);
	echo "/";
	fixlolnum($game->stats->assists);
	
	
	echo " - ";

	$won = $game->stats->win;

	if ($won == 1){
	  echo "Victory";
	}
	else {
	  echo "Defeat";

	}
	echo "<br><br>";
}


#print_r($recentGames->games[0]->stats);
?>
</pre>
</body>
</html>
