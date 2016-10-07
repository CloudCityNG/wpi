<?php
// LOCALHOST
$vconnServer = 'localhost';
$vconnUsername = 'admin';
$vconnPassword = 'secret';
$vconnDatabase = 'dbwpint';

// LIVE HOST
//  $vconnServer = 'sql30.jnb2.host-h.net';
//  $vconnUsername = 'creative01x';
//  $vconnPassword = 'nNAaJN2Bbg8';
//  $vconnDatabase = 'creativeangelsdb';
// // RW F5UYyMQq948
// RO LW1AF9XxCk8

	//Connect to MYSQL server
	$vconn_wpi = mysqli_connect($vconnServer, $vconnUsername, $vconnPassword, $vconnDatabase);

	if (!$vconn_wpi) {
		//REDIRECT TO ERROR PAGE WHEN CONNECTION FAILS
		header('Location: cms-conn-failed.php');
		exit();

	} else {

		//INDICATE WHICH DATABASE YOU WANT TO WORK WITH
		mysqli_select_db($vconn_wpi, $vconnDatabase);

	}

?>
