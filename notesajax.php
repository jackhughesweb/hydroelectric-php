<?php
session_start();
include 'config.php';
include 'markdown.php';
header('Content-type: text/plain');
$id = mysql_real_escape_string(stripslashes($_POST['id']));
if(isset($_SESSION['valid'])){
	$query = "SELECT * FROM notes WHERE `topic_id` = '" . $id . "'";
	$result = mysql_query($query);
	if(!$result){
		echo("2");
	}else{
		$count = mysql_num_rows($result);
		if($count < 1){
		}else{
			while ($row = mysql_fetch_array($result)) {
					echo "<div style='background-image: url(" . $row['back_img'] . "); background-position: center; background-size: cover; padding: 1em; padding-top: 3em; padding-bottom: 3em;' data-id='" . $row['id'] . "'><div style='padding: 1em; background-color: rgba(255,255,255,0.8); border-radius: 1em;'><span class='editpagecog editpagecogtopic' data-icon='c'>c</span>" . Markdown(nl2br($row['text'])) . "</div></div>";

				}
				
				
			}
		}
	
	echo("<div class='addnotes' data-id='" . $id . "'>+</dt>");
}else{
	echo("0");
}

?>