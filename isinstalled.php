<?php
include 'config.php';
header('Content-type: text/plain');
$query = "SELECT * FROM options";
$result = mysql_query($query);
if(!$result){
	echo "0";
	} else {
	$count = mysql_num_rows($result);
    
	if($count > 0){
		echo "1";
	}else{
		echo "0";
	}
}
?>