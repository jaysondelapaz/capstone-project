<?php

 $host = 'localhost';
 $user = 'root';
 $passwd = 'dev@12345';
 $db = "popcom2018ticketingDB";

try{

	$mysql = new PDO("mysql:host=$host;dbname=$db",$user,$passwd);
	$mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//echo"Successfully connected";

	//get current day from server
	$dateNow = $mysql->prepare("SELECT CURDATE() as cDate");
	$dateNow->execute();
	while($r=$dateNow->fetch(PDO::FETCH_OBJ))
		{
			$Today=$r->cDate;
		}

}catch(Exception $a){
	echo"ERROR: " .$a->getMessage();
}


?>