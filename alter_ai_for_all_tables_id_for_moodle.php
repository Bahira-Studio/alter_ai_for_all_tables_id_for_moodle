<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

define('dbhost', 'localhost');
define('dbname', 'your_database_name');
define('dbuser', 'your_database_user');
define('dbpass', 'your_database_password');

function koneksi() {
	$mysqli = new mysqli(dbhost, dbuser, dbpass, dbname);
  
  	if ($mysqli -> connect_errno) {
  		echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  		exit();
  	}
  
  	return $mysqli;
}

function alter_sql($table) {
 	return "ALTER TABLE `$table` CHANGE `id` `id` BIGINT(10) NOT NULL AUTO_INCREMENT;";
}

function get_all_table() {
	$result = koneksi() -> query("show tables;");
	$hasil = [];
	if($result) {
  		while ($row = $result -> fetch_row()) {
    		//echo ($row[0]) . "<br>";
          	array_push($hasil, $row[0]);
  		}
  		$result -> free_result();
	}  
  
  	return $hasil;
}

function alter_all_table_id_as_ai() {
  	$all_table = get_all_table();
  	if(empty($all_table)) {
    	die("Failed alter table: Empty on array");
    }
  	
  	date_default_timezone_set('Asia/Jakarta');
  	echo "<p> Script started at " . date('d/m/Y h:i:s a', time()) . "<br><br>";
  
  	foreach($all_table as $tableName) {   	
    	$sql = alter_sql($tableName);
      
		if (koneksi() -> query($sql)) {
  			echo "Successfuly alter : $tableName <br>" ;
		} else {
        	echo "Failed to alter table : $tableName  <br>";
        }
    }
  
  	echo "<br> <p> Script finished at " . date('d/m/Y h:i:s a', time());
}

alter_all_table_id_as_ai();
