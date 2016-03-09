<?php
	define("HOST", "localhost"); 			
	define("USER", "<DB_USER_HERE>"); 			
	define("PASSWORD", "<DB_PASS_HERE>"); 	
	define("DATABASE", "<DB_NAME_HERE>");         
	$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
	if ($mysqli->connect_error) {
		header("Location: ../index.php?err=Unable to connect to MySQL");
		exit();
	}