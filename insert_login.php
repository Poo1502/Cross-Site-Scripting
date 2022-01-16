<?php error_reporting(E_ERROR); ?>
<?php include_once ('config.php'); ?>
<?php include ('print_user.php'); ?>
<?php include ('browser_os_check.php'); ?>

<?php

function record_login($uname, $pwd, $attack) {
	$attacks = "";
	
	if (is_array ( $attack )) {
		foreach ( $attack as &$att ) {
			$attacks .= $att . ", ";
		}
	}
	
	$host = gethostname (); // hostname
	$real_IP = $_SERVER ['REMOTE_ADDR']; // real IP address
	$proxy_IP = $_SERVER ['HTTP_X_FORWARDED_FOR']; // proxy IP address
	$request = $_SERVER ['REQUEST_METHOD']; // request type
	
	$browser_os = detect_browser_os (); // detect browser and OS
	$browser = $browser_os [0]; // browser
	$os = $browser_os [1]; // OS
	                       
	// select the uname and pwd for determining if the login type is a success
	$select = "select * FROM users where uname = '$uname' and pwd = '$pwd'";
	
	$query = mysqli_query ( $select );
	
	// Use this to detect the type of login for a user, based on the num of rows
	// returned after the query is executed
	$att = strcmp ( $attacks, "" );
	if (mysqli_num_rows ( $query ) && $att == 0) {
		$attacks = "success";
	} else if ($att == 0) {
		$attacks = "failure";
	}
	
	// Insert login details for every user
	$insert_login = "insert INTO logins VALUES ('', '$uname', '$pwd', '$host', '$real_IP', '$browser', '$os', '$request', '$attacks')";
	$query = mysqli_query ( $insert_login );
	if ($query) {
		echo "<h1>Login inserted.</h1>";
	} else {
		echo "Error: " . $insert_login . "<br>";
	}
}
?>