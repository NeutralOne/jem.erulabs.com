
<?PHP

require 'secretfile.php';
require 'championlist.php';

#print_r($champions);
	

require 'vendor/autoload.php';
use LeagueWrap\Api;

$api = new Api($league_api_key);

$summonerAPI = $api->summoner();
$gameAPI = $api->game();

$name = $_POST['name'];

$summoner = $summonerAPI->info($name);

$recentGames = $gameAPI->recent($summoner->id);

echo "<img src='http://avatar.leagueoflegends.com/na/". ($name) . ".png' >" ;
echo "<br>". ($name) ."'s Past 10 Games: <br>";

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

?>
<table>
<tr>
	<td></td>
	<td>Stats</td>
	<td></td>
</tr>
<?PHP

foreach ($recentGames->games as $gameNum => $game) {
	$championId = $game->championId;
	$championName = $champions[$championId];	
	echo "<!---#$championId--->\n";

	echo "<tr>";
	echo "<td>";
	echo "<img src='/images/" . fixlolname($championName) . "Square.png'>";	
	echo "<br>";
	echo $championName;
	echo "</td>";

	echo "<td>";
	echo fixlolnum($game->stats->championsKilled);
	echo "/";
	echo fixlolnum($game->stats->numDeaths);
	echo "/";
	echo fixlolnum($game->stats->assists);
	echo "</td>";
	

	echo "<td>";
	$won = $game->stats->win;

	if ($won == 1){
	  echo "<span class='big victory'>Victory</span>";
	}
	else {
	  echo "<span class='big defeat'>Defeat</span>";

	}
	echo "<br>";
	if (fixlolnum($game->stats->numDeaths) > fixlolnum($game->stats->championsKilled)+4) {
	  echo " ...Goddamn feeder.";
	}
	if ((fixlolnum($game->stats->championsKilled) > fixlolnum($game->stats->numDeaths)+4) && $won == 1) {
	  echo " ...Good job!";
	}	

	echo "</td>";
	echo "</tr>\n\n";
}
#foreach ($champions as $championId => $championName) {
#	
#	echo "<img src='/images/" . fixlolname($championName) . "Square.png'>";	
#}

#print_r($recentGames->games[0]->stats);
?>
</table>
<br><br><br>
