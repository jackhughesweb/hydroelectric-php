<?php
session_start();
include 'config.php';
header('Content-type: text/plain');
if(isset($_SESSION['valid'])){
	$query = "SELECT * FROM subjects";
	$result = mysql_query($query);
	if(!$result){
		echo("2");
	}else{
		$count = mysql_num_rows($result);
		if($count < 1){
			
		}else{
			$text = "";
			while ($row = mysql_fetch_array($result)) {
				$text = "<dt class='" . $row["colour"] . "' data-id='" . $row['id'] . "'><span class='examboard'>" . $row["exam_board"] . "</span> <span class='subjecttitle'>" . $row["name"] . "</span><i data-icon='c' class='editpagecog editpagecogsubject'>c</i></dt><dd class='" . $row["colour"] . " slideout'><ul>";


				$query2 = "SELECT * FROM topics WHERE subject_id = " . $row['id'];
				$result2 = mysql_query($query2);
				if(!$result2){
					echo("2");
				}else{
					$count2 = mysql_num_rows($result2);
					if($count2 < 1){
					}else{
						while ($row2 = mysql_fetch_array($result2)) {
							$text .= "<li data-id='" . $row2["id"] . "'>" . $row2["name"] . "</li>";
						}

					}

				}



				$text .= "<li class='topicadd' data-id='" . $row['id'] . "'>+</li></ul></dd>";
				echo $text;
			}
		}
	}
	echo("<dt class='add'>+</dt>");
}else{
	echo("0");
}

?>