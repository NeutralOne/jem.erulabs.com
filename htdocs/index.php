
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


?>
<!DOCTYPE html>

<html>
<head>
<title>LeagueSite</title>
<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
<b><i><font color="white"><font size=9><center>Only you can hear me, Summoner.</center></font>
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
	Summoner Name:
	<br>
	<input type="text" name="name">
	<br>
	<input type="submit" value="submit">
</form>

Hello
<?php
if (!isset($_POST["name"])){
	echo "Summoner";
	echo "<br><br>";
	
} else {
	echo $_POST["name"];
	echo "<br><br><br>";
	require 'gamedisplay.php';
}

function sanitize($input) {
	$output = mysqli_real_escape_string($connection, $input);
	return $output;
}

if (isset($_POST["commentName"]) && isset($_POST["comment"])) {
		
	
	$insert = mysqli_query($connection, "INSERT INTO `comments` (`name`,`words`) VALUES ('".sanitize($_POST['commentName'])."', '".sanitize($_POST['comment'])."')");
}

require 'comments.php';
?>
<form action="index.php" method="post">
        Name:
	<br>
        <input type="text" name="commentName">
        <br>
	Comment:
	<br>
	<input type="text" name="comment">
	<br>
        <input type="submit" value="submit">
</form>

</body>
</html>
