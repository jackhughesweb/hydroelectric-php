<?php
session_start();
include 'config.php';
header('Content-type: text/plain');
$id = mysql_real_escape_string(stripslashes($_POST['id']));
$notes = mysql_real_escape_string(stripslashes($_POST['notes']));
$backimg = mysql_real_escape_string(stripslashes($_POST['backimg']));
if(isset($_SESSION['valid'])){
	$query = "UPDATE `notes` SET `text`='" . $notes . "', `back_img`='" . $backimg . "' WHERE `id` = '" . $id . "'";
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