<?php
session_start();
include 'config.php';

if(isset($_SESSION['valid'])){
	//get all of the tables
  
    $tables = array();
    $result = mysql_query('SHOW TABLES');

    while($row = mysql_fetch_row($result))
    {
      $tables[] = $row[0];

    }


 
 
 $return = "";
  //cycle through
  foreach($tables as $table){
    
    $result = mysql_query('SELECT * FROM '.$table);
    $num_fields = mysql_num_fields($result);
    //print_r($num_fields);exit;
    $return.= 'DROP TABLE '.$table.';';
    $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
    $return.= "\n\n".$row2[1].";\n\n";

    for ($i = 0; $i < $num_fields; $i++) 
    {
      while($row = mysql_fetch_row($result))
      {
        $return.= 'INSERT INTO '.$table.' VALUES(';
        for($j=0; $j<$num_fields; $j++) 
        {
          $row[$j] = addslashes($row[$j]);
         // $row[$j] = preg_replace("\n","\\n",$row[$j]);

          $row[$j] = preg_replace("/(\n){2,}/", "\\n", $row[$j]); 

          if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
          if ($j<($num_fields-1)) { $return.= ','; }
        }
        $return.= ");\n";
      }
    }
    $return.="\n\n\n";

  }

 
//add below code to download it as a sql file
Header('Content-type: application/octet-stream');
Header('Content-Disposition: attachment; filename=hydroelectric-backup-'.date('Y-m-d-G-i-s').'-'.(md5(implode(',',$tables))).'.sql');
echo $return;


}else{
	die();
}

?>

