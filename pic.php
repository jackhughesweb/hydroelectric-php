<?php
header('Content-type: image/jpeg');
session_start();
include 'config.php';
if(isset($_SESSION['valid'])){
	$query = "SELECT * FROM options";
	$result = mysql_query($query);
	if(!$result){
		die();
	}
	$userData = mysql_fetch_array($result, MYSQL_ASSOC);
	$email = $userData["email_md5"];
	$location = "http://www.gravatar.com/avatar/" . $email . ".jpg";
	$picture = file_get_contents("$location");
	echo $picture;
}else{
	$email = "00000000000000000000000000000000";
	$location = "http://www.gravatar.com/avatar/" . $email . ".jpg";
	$picture = file_get_contents("$location");
	echo $picture;
}
?>