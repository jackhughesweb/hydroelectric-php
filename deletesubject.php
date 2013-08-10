<?php
session_start();
include 'config.php';
header('Content-type: text/plain');
$id = mysql_real_escape_string(stripslashes($_POST['id']));
if(isset($_SESSION['valid'])){
	$query = "DELETE FROM `subjects` WHERE `id` = '" . $id . "'";
	$result = mysql_query($query);
	if(!$result){
		echo("2");
	}else{
		$query2 = "DELETE FROM `topics` WHERE `subject_id` = '" . $id . "'";
		$result2 = mysql_query($query2);
		if(!$result2){
			echo("2");
		}else{
			echo("1");
		}
	}
}else{
	echo("0");
}

?>