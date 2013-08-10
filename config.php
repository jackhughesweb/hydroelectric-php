<?php
//AppFog Only
$services_json = json_decode(getenv("VCAP_SERVICES"),true);
$mysql_config = $services_json["mysql-5.1"][0]["credentials"];
$databaseUsername = $mysql_config["username"];
$databasePassword = $mysql_config["password"];
$databaseHostName = $mysql_config["hostname"] . ":" . $mysql_config["port"];
$databaseName = $mysql_config["name"];
//Database name
// $databaseName = '';
//Database username
// $databaseUsername = '';
//Database password
// $databasePassword = '';
//Database hostname
// $databaseHostName = '';
//Open MySQL connection to server
$link = mysql_connect($databaseHostName, $databaseUsername, $databasePassword);
//Select MySQL database
$db_selected = mysql_select_db($databaseName, $link);
//Check if connection worked
if(!$link){
	die();
}

if (!$db_selected){
	$sql = 'CREATE DATABASE hydroelectric';
	if(!mysql_query($sql, $link)){
		die();
	}
}

?>