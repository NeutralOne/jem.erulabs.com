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

Hello
<?php

echo $_GET["name"];

?>
<br><Br><br>
<pre>
<?PHP


require 'championlist.php';

print_r($champions);

exit();

require 'vendor/autoload.php';
use LeagueWrap\Api;

$api = new Api('3c89c9d9-6196-463b-9c7b-2ef2f83540f8');

$summonerAPI = $api->summoner();

$name = $_GET['name'];

$summoner = $summonerAPI->info($name);

print_r($champions);
#print_r($summoner);


?>
</pre>
</body>
</html>
