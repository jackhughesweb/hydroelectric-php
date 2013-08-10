<?php
session_start();
include 'config.php';
if(isset($_SESSION['valid'])){
	$query = "SELECT * FROM options";
	$result = mysql_query($query);
	if(!$result){
		die();
	}
	$userData = mysql_fetch_array($result, MYSQL_ASSOC);
	$name = $userData["name"];
	echo $name;
}else{
	echo "0";
}
?>