<?php

	// connect database
	$host 		= 'db'; // your database container in docker-compose
	$user			= 'user';
	$password	= 'password';
	$database	= 'test_db';
	$conn 		= mysqli_connect($host, $user, $password, $database);

	// check connection
	if(!$conn) {
		echo 'Connection error: ' . mysqli_connect_error();
	}

?>
