<?php
session_start();
include 'config.php';
header('Content-type: text/plain');
$subject = mysql_real_escape_string(stripslashes($_POST['subject']));
$exam = mysql_real_escape_string(stripslashes($_POST['exam']));
$colour = mysql_real_escape_string(stripslashes($_POST['colour']));
if(isset($_SESSION['valid'])){
	$query = "INSERT INTO `subjects` (`name`, `exam_board`, `colour`) VALUES ('" . $subject . "', '" . $exam . "', '" . $colour . "')";
	$result = mysql_query($query);
	if(!$result){
		echo('{ "status": "failed"}');
	}else{
		echo('{ "status": "ok", "id": "' . mysql_insert_id() . '"}');
	}
}else{
	echo('{ "status": "failed"}');
}

?>