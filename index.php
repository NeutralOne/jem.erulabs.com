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
	exit();
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
	  return 0;
	} else {
	  return $lolnumber;
	}
}


function fixlolname($lolname) {
	$lolname = str_replace(" ", "", $lolname);
	$lolname = str_replace("'", "", $lolname);
	$lolname = str_replace(".", "", $lolname);
	return $lolname;
}


foreach ($recentGames->games as $gameNum => $game) {

	$championId = $game->championId;
	
	$championName = $champions[$championId];
	
	echo "<!---#$championId--->";

	echo "<img src='/images/" . fixlolname($championName) . "Square.png'>";	

	echo $championName;

	echo " - ";

	echo fixlolnum($game->stats->championsKilled);
	echo "/";
	echo fixlolnum($game->stats->numDeaths);
	echo "/";
	echo fixlolnum($game->stats->assists);
	
	
	echo " - ";

	$won = $game->stats->win;

	if ($won == 1){
	  echo "<font color='green'>Victory</font>";
	}
	else {
	  echo "<font color='red'>Defeat</font>";

	}
	
	if (fixlolnum($game->stats->numDeaths) > fixlolnum($game->stats->championsKilled)+4) {
	  echo " ...Goddamn feeder.";
	}
	if ((fixlolnum($game->stats->championsKilled) > fixlolnum($game->stats->numDeaths)+4) && $won == 1) {
	  echo " ...Good job!";
	}	

	echo "<br>\n\n";
}


#print_r($recentGames->games[0]->stats);
?>
</pre>
</body>
</html>
