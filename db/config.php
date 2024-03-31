<?php
	$host="localhost";
	$username="root";
	$password="root";
	$database="flashcard";
	try{
		$connection=new PDO("mysql:host=$host;dbname=$database","$username","$password");
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//echo "connected";
	}
	catch(PDOException $e){
		die("Something went wrong in the database");
		echo $e->getMessage();
	}
?>