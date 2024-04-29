<?php
	$host = "localhost";
	$dbname = "db_m6_aplin";
	$username = "root";
	$password = "";

	try {
		$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		die("Connection failed : ". $e-> getMessage());
	}
