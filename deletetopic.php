<?php
session_start();
include 'config.php';
header('Content-type: text/plain');
$id = mysql_real_escape_string(stripslashes($_POST['id']));
if(isset($_SESSION['valid'])){
	$query = "DELETE FROM `topics` WHERE `id` = '" . $id . "'";
	$result = mysql_query($query);
	if(!$result){
		echo("2");
		
	}else{
		echo("1");
	}
}else{
	echo("0");
}

?>