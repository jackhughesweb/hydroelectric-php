<?php
ob_start(); // begin collecting output
include 'isinstalled.php';
$result = ob_get_clean(); // retrieve output from myfile.php, stop buffering
if($result == "1"){
  echo "0";
  die();
}
session_start();
unset($_SESSION['valid']);
include 'config.php';
header('Content-type: text/plain');
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
$query = "
CREATE TABLE IF NOT EXISTS `login_ips` (
  `ip` text CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `attempts` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
";
$result = mysql_query($query);
if(!$result){
	echo "0";
	die();
}
$query = "
CREATE TABLE IF NOT EXISTS `notes` (
  `topic_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `back_img` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
";
$result = mysql_query($query);
if(!$result){
	echo "0";
	die();
}
$query = "
CREATE TABLE IF NOT EXISTS `options` (
  `password` text NOT NULL,
  `salt` text NOT NULL,
  `name` text NOT NULL,
  `email_md5` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
";
$result = mysql_query($query);
if(!$result){
	echo "0";
	die();
}
$query = "
INSERT INTO `options` (`password`, `salt`, `name`, `email_md5`) VALUES
('" . $password . "', '" . $salt . "', '" . $name . "', '" . $email . "');
";
$result = mysql_query($query);
if(!$result){
	echo "0";
	die();
}
$query = "
CREATE TABLE IF NOT EXISTS `subjects` (
  `name` text NOT NULL,
  `exam_board` text NOT NULL,
  `colour` text NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
";
$result = mysql_query($query);
if(!$result){
	echo "0";
	die();
}
$query = "
CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_id` int(11) NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

";
$result = mysql_query($query);
if(!$result){
	echo "0";
	die();
}else{
	echo "1";
}

?>