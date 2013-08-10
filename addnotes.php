<?php
session_start();
include 'config.php';
header('Content-type: text/plain');
$id = mysql_real_escape_string(stripslashes($_POST['id']));
$notes = mysql_real_escape_string(stripslashes($_POST['notes']));
$backimg = mysql_real_escape_string(stripslashes($_POST['backimg']));
if(isset($_SESSION['valid'])){
	$query = "INSERT INTO `notes` (`topic_id`, `text`, `back_img`) VALUES (" . $id . ", '" . $notes . "', '" . $backimg . "')";
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