<?php
//Database connection
session_start();
include 'config.php';
//Get password and ip
$password = mysql_real_escape_string(stripslashes($_POST['password']));
$ip = mysql_real_escape_string(stripslashes($_SERVER["REMOTE_ADDR"]));

$query = "SELECT * FROM options";
$result = mysql_query($query);
if(!$result){
	echo("2");
	die();
}
$userData = mysql_fetch_array($result, MYSQL_ASSOC);
$salt = $userData["salt"];
$password = hash('sha256', $password . $salt);
//Delete any attempts longer than 10 minutes
$query10 = "DELETE FROM login_ips WHERE timestamp < (NOW() - INTERVAL 10 MINUTE)";
//Run query
$result10 = mysql_query($query10);
//Check query worked
if(!$query10){
	//Query did not work
 	echo("2");
}else{
	//Query did work
	//Check if user has any failed attempts
	$query5 = "SELECT * FROM login_ips WHERE ip = '$ip'";
	//Run query
	$result5 = mysql_query($query5);
	//Check query worked
	if(!$query5){
		//Query did not work
 		echo("2");
	}else{
		//Query did work
		//Count number of failed attempts
 	   	$count5 = mysql_num_rows($result5);
    	//Check no failed attempts have been made
		if($count5 < 1){
			//No failed attempts have been made
			//Check password
			$query = "SELECT * FROM options WHERE password = '$password'";
			//Run query
			$result = mysql_query($query);
			//Check query worked
			if(!$query){
				//Query did not work
 				echo("2");
			}else{
				//Query did work
				//Count number of rows returned
    			$count = mysql_num_rows($result);
    			//Check if no rows returned
				if($count < 1){
					//No rows returned, password invalid
					//Check user has already made failed attempts
					$query2 = "SELECT * FROM login_ips WHERE ip = '$ip'";
					//Run query
					$result2 = mysql_query($query2);
					//Check query worked
					if(!$query2){
 						//Query did not work
 						echo("2");
					}else{
						//Query did work
						//Count number of rows
 	   					$count2 = mysql_num_rows($result2);
 	   					//Check if no rows returned
						if($count2 < 1){
							//No rows returned, create new failed attempt record
							$query3="INSERT INTO login_ips(ip, attempts)VALUES('$ip', '1')";
							//Run query
							$result3 = mysql_query($query3);
							//Check query worked
							if(!$query3){
								//Query did not work
 								echo("2");
							}else{
								//Query did work
								echo("0");
							}
						}else{
							//Rows returned, update failed attempt record
							//Get data returned
							$userData2 = mysql_fetch_array($result2, MYSQL_ASSOC);
							//Get attempts
							$attempts = $userData2["attempts"];
							//Increment attempts by one
							$attempts += 1;
							//Update record
							$query3="UPDATE login_ips SET attempts = '$attempts' WHERE ip = '$ip'";
							//Run query
							$result3 = mysql_query($query3);
							//Check query worked
							if(!$query3){
								//Query did not work
 								echo("2");
							}else{
								//Query did work
								echo("0");
							}
						}
					}
				}else{
					//Password valid
					$query10 = "DELETE FROM login_ips WHERE ip = '$ip'";
					$result10 = mysql_query($query10);
					$_SESSION['valid'] = '1';
					
					echo("1");
				}
			}
		}else{
			//Failed attempts have been made
			//Get data returned
			$userData5 = mysql_fetch_array($result5, MYSQL_ASSOC);
			$attempts = $userData5["attempts"];
			if($attempts < 4){
			$query = "SELECT * FROM options WHERE password = '$password'";
			//Run query
			$result = mysql_query($query);
			//Check query worked
			if(!$query){
				//Query did not work
 				echo("2");
			}else{
				//Query did work
				//Count number of rows returned
    			$count = mysql_num_rows($result);
    			//Check if no rows returned
				if($count < 1){
					//No rows returned, password invalid
					//Check user has already made failed attempts
					$query2 = "SELECT * FROM login_ips WHERE ip = '$ip'";
					//Run query
					$result2 = mysql_query($query2);
					//Check query worked
					if(!$query2){
 						//Query did not work
 						echo("2");
					}else{
						//Query did work
						//Count number of rows
 	   					$count2 = mysql_num_rows($result2);
 	   					//Check if no rows returned
						if($count2 < 1){
							//No rows returned, create new failed attempt record
							$query3="INSERT INTO login_ips(ip, attempts)VALUES('$ip', '1')";
							//Run query
							$result3 = mysql_query($query3);
							//Check query worked
							if(!$query3){
								//Query did not work
 								echo("2");
							}else{
								//Query did work
								echo("0");
							}
						}else{
							//Rows returned, update failed attempt record
							//Get data returned
							$userData2 = mysql_fetch_array($result2, MYSQL_ASSOC);
							//Get attempts
							$attempts = $userData2["attempts"];
							//Increment attempts by one
							$attempts += 1;
							//Update record
							$query3="UPDATE login_ips SET attempts = '$attempts' WHERE ip = '$ip'";
							//Run query
							$result3 = mysql_query($query3);
							//Check query worked
							if(!$query3){
								//Query did not work
 								echo("2");
							}else{
								//Query did work
								echo("0");
							}
						}
					}
				}else{
					//Password valid
					$query10 = "DELETE FROM login_ips WHERE ip = '$ip'";
					$result10 = mysql_query($query10);
					$_SESSION['valid'] = '1';
					echo("1");
				}
			}

	}else{
	//Too many attempts have been made
	echo("3");
	}
}
}
}

?>