<?php
session_start();
include 'config.php';
header('Content-type: text/plain');
$id = mysql_real_escape_string(stripslashes($_POST['id']));
if(isset($_SESSION['valid'])){
	$query = "SELECT * FROM notes WHERE `id` = '" . $id . "'";
	$result = mysql_query($query);
	if(!$result){
		echo("2");
	}else{
		$count = mysql_num_rows($result);
		if($count < 1){
		}else{
			while ($row = mysql_fetch_array($result)) {
					echo $row['text'];

				}
				
				
			}
		}
	
	
}else{
	echo("0");
}

?>