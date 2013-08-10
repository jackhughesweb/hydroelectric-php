<?php
session_start();
include 'config.php';
header('Content-type: text/plain');
$id = mysql_real_escape_string(stripslashes($_POST['id']));
if(isset($_SESSION['valid'])){
	$query = "SELECT * FROM topics WHERE `id` = '" . $id . "'";
	$result = mysql_query($query);
	if(!$result){
		echo "0";
	}else{
		$count = mysql_num_rows($result);
		if($count < 1){
		}else{
			$data = mysql_fetch_array($result, MYSQL_ASSOC);
			$subject_id = $data["subject_id"];
					$query2 = "SELECT * FROM subjects WHERE `id` = '" . $subject_id . "'";
					$result2 = mysql_query($query2);
					if(!$result2){
						echo "0";
					}else{
						$count2 = mysql_num_rows($result2);
						if($count2 < 1){
						}else{
							$data2 = mysql_fetch_array($result2, MYSQL_ASSOC);
							
								echo $data2["colour"];
								
							}
						}
				
			}
		}
	
	
}else{
	echo "0";
}

?>