<?php
session_start();
include 'config.php';
header('Content-type: text/plain');
if(isset($_SESSION['valid'])){

$sql_contents = $_POST['texttoimport'];

$sql_contents = explode(";", $sql_contents);
    

foreach($sql_contents as $query){
       $result = mysql_query($query);
       
		
	}
echo '1';
}else{
	echo '0';
	die();
}
?>