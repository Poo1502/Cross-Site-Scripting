<?php error_reporting(E_ERROR); ?>
<?php

 
$database = "honeypot";
$hostname = "localhost";
$username = "root";
$password = "";

$dbc = mysqli_connect ( $hostname, $username, $password );
if (! $dbc)
	die ( 'Could not connect: ' . mysqli_connect_error() );
else
	$db = mysqli_select_db ( $database, $dbc );
?>