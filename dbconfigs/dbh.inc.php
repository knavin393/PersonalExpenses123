<?php
$servername ="localhost";
$dBUsername ="root";
$dBPassword ="";
$dBName ="star";

$conn =mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if(!$conn){
	die("Connection failed: ".mysqli_connect_error());
}

/* Heroku remote server */
$i++;
$cfg["Servers"][$i]["host"] = "us-cdbr-east-06.cleardb.net"; //provide hostname
$cfg["Servers"][$i]["user"] = "bf71fc7d365bc5"; //user name for your remote server
$cfg["Servers"][$i]["password"] = "bcf9e4f3"; //password
$cfg["Servers"][$i]["auth_type"] = "config"; // keep it as config
?>