<?php
   // Uncomment this block for debug.
   // It writes the raw POST data to a file.
   
   $fn = "log3.txt";
   $fp = fopen($fn, "a");
   $rawPostData = file_get_contents('php://input');
   fwrite($fp, date("l F d, Y, h:i A") . "," . $rawPostData . "\n");   
   fclose($fp);
   
     
   // Define the user name, password,
   // MySQL hostname and database name.
   //define("DB_USER", "root");
   //define("DB_PASS", "");
   //define("DB_HOST", "localhost");
   //define("DB_NAME", "comercial");
     
   //Store the POST variables.
   $readerName=$_POST['reader_name'];
   $macAddress=$_POST['mac_address'];
   $lineEnding=$_POST['line_ending'];
   $fieldDelim=$_POST['field_delim'];
   $fieldNames=$_POST['field_names'];
   $fieldValues=$_POST['field_values'];
     
   // Connect to the database.
   //$con = mysql_connect(DB_HOST, DB_USER, DB_PASS);
   //mysql_select_db(DB_NAME) or die( "Unable to select database");
     
   // Replace the field delimiter with a comma.
   str_replace($fieldDelim, ",", $fieldNames);
     
   // Break the field values up into rows.
   $rows = explode("\n", $fieldValues);

   	
     
   // Remove the last row. It's always blank
   //if (sizeof($rows)) array_pop($rows);
     
   //$fieldNames = "reader_name,mac_address," . $fieldNames;               
     
   foreach ($rows as $row)
   {
   		$fn_2 = "log4.txt";
        $fp2 = fopen($fn_2, "a");
        //fwrite($fp2, date("l F d, Y, h:i A") . "," . $fieldNames.":: ".$row."\n");   
        fwrite($fp2,$row."\n");
		fclose($fp2);
      
	  
	  /*$row = $readerName . "," . $macAddress . "," .$row;
      $query = "INSERT INTO tags ($fieldNames) VALUES ($row)";
      echo $query . "\n";
      mysql_query($query); */      
   }               
     
   //mysql_close($con);
?>	