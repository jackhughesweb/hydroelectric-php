<?php
session_start();
include 'config.php';
header('Content-type: text/plain');
$subject = mysql_real_escape_string(stripslashes($_POST['subject']));
$exam = mysql_real_escape_string(stripslashes($_POST['exam']));
$colour = mysql_real_escape_string(stripslashes($_POST['colour']));
$id = mysql_real_escape_string(stripslashes($_POST['id']));
if(isset($_SESSION['valid'])){
	$query = "UPDATE `subjects` SET `name`='" . $subject . "', `exam_board`='" . $exam . "', `colour`='" . $colour . "' WHERE `id` = '" . $id . "'";
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