<?php
session_start();
include 'config.php';
header('Content-type: text/plain');
$id = mysql_real_escape_string(stripslashes($_POST['id']));
$name = mysql_real_escape_string(stripslashes($_POST['topic']));
if(isset($_SESSION['valid'])){
	$query = "UPDATE `topics` SET `name`='" . $name . "' WHERE `id` = '" . $id . "'";
	$result = mysql_query($query);
	if(!$result){
		echo mysql_error($query);
		echo $query;
	}else{
		echo("1");
	}
}else{
	echo("0");
}

?>