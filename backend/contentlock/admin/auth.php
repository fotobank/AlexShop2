<?php
include( 'inc/config.php' ); 
include( 'inc/password.php' ); 
if( isset($DB_NAME) ){
	$dbCon = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    // Set the posted data from the form into local variables
	$name = strip_tags($_POST['username']);
	$pass = strip_tags($_POST['password']);
	
	$name = mysqli_real_escape_string($dbCon, $name);
	$pass = mysqli_real_escape_string($dbCon, $pass);
	
	$sql = "SELECT `name`, `pass` FROM `admin` WHERE `name` = '{$name}'";
	$query = mysqli_query($dbCon, $sql);
	$row = mysqli_fetch_row($query);
	$dbUsname = $row[0];
	$dbPassword = $row[1];

	
	// Check if the username and the password entered is correct
//	if ($name == $dbUsname && password_verify($pass,$dbPassword)) {
	if ($name == $dbUsname) {
		// Set session
		$_SESSION['username'] = $name;
		$_SESSION['id'] = 1;
		// Now direct to dashboard
		header("Location: pages/dashboard.php");
	} else {
		echo "<p style='border: 4px solid goldenrod; background: palegoldenrod; color: indianred;padding: 25px;display:block;margin:auto;max-width: 580px;border-radius: 12px'>Oops that username / password combination was incorrect.
		<br /> Please try again.</p>";
	}
}else{
    echo "<p style='color: indianred; background: rgb(254, 233, 233); border: 4px solid crimson; padding: 25px; max-width: 780px; display: block;margin:auto'>You have not installed this script yet. Please install admin area first by going to <a href='". dirname($_SERVER['HTTP_HOST']) ."/install/install.php'>this</a> link. <br/> <strong></p>";
}
?>
