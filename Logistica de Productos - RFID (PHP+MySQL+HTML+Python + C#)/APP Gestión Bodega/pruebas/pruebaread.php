<?php
   // Uncomment this block for debug.
   // It writes the raw POST data to a file.
   
     
   define("DB_USER", "root");
   define("DB_PASS", "");
   define("DB_HOST", "localhost");
   define("DB_NAME", "comercial");
     
   //Store the POST variables.
   //$fieldDelim=$_POST['field_delim'];
   //$fieldNames=$_POST['field_names'];
   //$fieldValues=$_POST['field_values'];
   $fieldNames=".";
   $fieldDelim=".";
   
   $fieldValues='1,"0001FB63AC1F3841EC88046B",1404485787978195,""';
   $fieldValues.="\n".'5,"0005FB63AC1F3841EC880467",1404485788898972,""';
     
   // Connect to the database.
   $con = mysql_connect(DB_HOST, DB_USER, DB_PASS);
   mysql_select_db(DB_NAME) or die( "Unable to select database");
     
   // Replace the field delimiter with a comma.
   str_replace($fieldDelim, ",", $fieldNames);
     
   // Break the field values up into rows.
   $rows = explode("\n", $fieldValues);

   	
   foreach ($rows as $row)
   {
   	$fn_2 = "log2.txt";
        $fp2 = fopen($fn_2, "a");
        fwrite($fp2,$row."\n");
	fclose($fp2);
	
		$vecdata=explode(",",$row);
     
		$vecdata[1]=addslashes($vecdata[1]);
		$vecdata[1]=str_replace('\"',"",$vecdata[1]);
		echo $vecdata[1];	
	  
	  	if($vecdata[0]>=1 and $vecdata[0]<=4){
			$query = "INSERT INTO tags (antena,tag,tipo) VALUES ('".$vecdata[0]."','".$vecdata[1]."','1')";
		}else if($vecdata[0]>=5 and $vecdata[0]<=8){
			$query = "INSERT INTO tags (antena,tag,tipo) VALUES ('".$vecdata[0]."','".$vecdata[1]."','2')";
		}
		mysql_query($query);      
   }               
     
   mysql_close($con);
?>	