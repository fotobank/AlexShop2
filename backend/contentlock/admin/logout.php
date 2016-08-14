<?php
session_start();
session_destroy(); 
if (isset($_SESSION['username'])) { 
	$msg = "You are now logged out";
} else {
	$msg = "<h2>You are already logged out</h2>";
} 
?> 
<html>
<body>
<?php echo $msg; ?><br>
<p><a href="index.php">Click here</a> to return to login page </p>
</body>
</html>