<?php
session_start();
include 'config.php';
header('Content-type: text/plain');
if(isset($_SESSION['valid'])){
$name = mysql_real_escape_string(stripslashes($_POST['name']));
$email = mysql_real_escape_string(stripslashes($_POST['email']));
$password = mysql_real_escape_string(stripslashes($_POST['password']));
$characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$i = 0;
$salt = "";
while ($i < 3) {
$salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
$i++;
}
$password = hash('sha256', $password . $salt);
$query = "UPDATE `options` SET `password` = '" . $password . "', `salt` = '" . $salt . "', `name` = '" . $name . "', `email_md5` = '" . $email . "'";
$result = mysql_query($query);
if(!$result){
	echo "0";
	die();
}else{
  echo "1";
}
}else{
  echo "0";
  die();
}
?>