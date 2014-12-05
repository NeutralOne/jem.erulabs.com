<?PHP
$connection = mysqli_connect('localhost','jem','sometatas','jemdb');
if($connection === false) {
	echo mysqli_connect_error();
}
    function db_select($query) {
	global $connection;
        $rows = array();
        $result = mysqli_query($connection, $query);

        // If query failed, return `false`
        if($result === false) {
            return false;
        }

        // If query was successful, retrieve all the rows into an array
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }


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
<?PHP
$result = db_select("SELECT * FROM visitData");
$found = false;
$totalVisits = 1;
//print_r($result);
foreach ($result as $visitorData) {
//print_r ($visitorData);	
	//echo $visitorData["IP"];
	//echo "<br>";
	//If this record is for your address

	$totalVisits = $totalVisits + $visitorData["visits"];
	if ($visitorData["IP"] == $_SERVER['REMOTE_ADDR']) {
		$found = true;
	$visits = $visitorData["visits"];
	}
	
}
if ($found) {
	//update
	$visits = $visits+1;
	$update = mysqli_query($connection, "UPDATE `visitData` SET `visits`=".$visits." WHERE `IP`='".$_SERVER['REMOTE_ADDR']."'");
}
else{
	$visits = 1;
	$insert = mysqli_query($connection, "INSERT INTO `visitData` (`IP`,`visits`) VALUES ('".$_SERVER['REMOTE_ADDR']."', 1)");
	//insert
}
echo "Your visits: ".$visits." <br>";
echo "Total visits: ".$totalVisits." <br>";
echo "Total unique visits: ".count($result)." <br><br>";


//echo $_SERVER['REMOTE_ADDR']
?>
<form action="index.php" method="post">
	Name:
	<br>
	<input type="text" name="name">
	<br>
	<input type="submit" value="submit">
</form>

Hello
<?php
if (!isset($_POST["name"])){
	echo "Summoner";
	exit();
} else {
	echo $_POST["name"];
}


?>
<br><Br><br>

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

echo "<img src='http://avatar.leagueoflegends.com/na/". ($name) . ".png' >" ;
echo "<br>". ($name) ."'s Past 10 Games: <br> <pre>";

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

	echo "<br><br>\n\n";
}
#foreach ($champions as $championId => $championName) {
#	
#	echo "<img src='/images/" . fixlolname($championName) . "Square.png'>";	
#}

#print_r($recentGames->games[0]->stats);
?>
</pre>
</body>
</html>
