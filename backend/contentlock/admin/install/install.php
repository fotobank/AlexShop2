<?php
	if ( !file_exists("install.txt") )
		die( "<p style='color: indianred; background: rgb(254, 233, 233); border: 4px solid crimson; padding: 25px; max-width: 780px; display: block;margin:auto'>ContentLocker is already installed, you are not authorized to be here.</p>" );
	$step = isset( $_POST['step'] ) ? $step = $_POST['step'] : 0; 
	if( $step === 0 ) { 
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
	<title>Install</title>
    <link rel="icon" href="../favicon.ico">

    <!-- Bootstrap core CSS -->
	<link type="text/css" rel="stylesheet" href="../assets/css/bootstrap.min.css" />

    <!-- Custom styles for this template -->
    <link href="../assets/css/install.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<style type="text/css">
	html {
		font-family: 'Roboto', sans-serif;
	}
	body, html{
		margin: 0;
		padding: 0;
		height: 100%;
	}
	body {
	  padding-top: 40px;
	  padding-bottom: 40px;
	  background:
		-webkit-linear-gradient(45deg, hsla(225, 97%, 46%, 1) 0%, hsla(225, 97%, 46%, 0) 70%),
		-webkit-linear-gradient(315deg, hsla(186, 99%, 45%, 1) 10%, hsla(186, 99%, 45%, 0) 80%),
		-webkit-linear-gradient(225deg, hsla(145, 96%, 49%, 1) 10%, hsla(145, 96%, 49%, 0) 80%),
		-webkit-linear-gradient(135deg, hsla(336, 93%, 45%, 1) 100%, hsla(336, 93%, 45%, 0) 70%);
	  background:
		linear-gradient(45deg, #9a93ae 0%, hsla(225, 97%, 46%, 0) 70%),
		linear-gradient(135deg, #cfd2c7 10%, hsla(186, 99%, 45%, 0) 80%),
		linear-gradient(225deg, #b4b1b6 10%, hsla(145, 96%, 49%, 0) 80%),
		linear-gradient(315deg, #9a93ae 100%, hsla(336, 93%, 45%, 0) 70%);
	}
	h2{
		text-align: center;
		margin: 20px 0 30px
	}
	.form-signin {
	  	max-width: 560px;
		padding: 20px 45px;
		margin: auto;
		margin-top: 7em;
		background: rgba(236, 239, 209, 0.15);
		border: 2px solid #D5D3CC;
	}
	.form-signin .form-control {
	  position: relative;
	  height: auto;
	  -webkit-box-sizing: border-box;
	     -moz-box-sizing: border-box;
	          box-sizing: border-box;
	  padding: 10px;
	  font-size: 16px;
	}
	.form-control, label, .btn-block{
	  max-width: 300px;
	  margin: auto;
	}
	label{display: block;}
	.form-signin .form-control:focus {
	  z-index: 2;
	}
	.form-signin input[type="text"] {
	  margin-bottom: 10px;
	  border-bottom-right-radius: 0;
	  border-bottom-left-radius: 0;
	}
	.form-signin input[type="password"] {
	  margin-bottom: 10px;
	  border-top-left-radius: 0;
	  border-top-right-radius: 0;
	}
	.step{
		display: inline-block;
		position: relative;
		width: 46px;
		height: 46px;
		-webkit-border-radius: 50%;
		border-radius: 50%;
		border: 1px solid steelblue;
		background: rgba(236, 239, 209, 0.15);
		padding: 10px 0;
		text-align: center;
	}
	#step-1, #step-2{margin-right: 20px;}
	#step-1:after, #step-2:after{
		content: ' ';
		display: block;
		position: absolute;
		top: 23px;
		right: -25px;
		width: 25px;
		height: 2px;
		background: black;
		z-index: -1
	}
	.step.active{border-color: crimson;}
	#steps{text-align: center;}
	.btn-primary-outline{
		margin-top: 40px;
		margin-bottom: 10px;
	}
	.step-data{display: none;}
	.step-data.active{display: block;}
	.error{border-color: crimson}
	.msg{
		color: indianred; 
		background: rgb(254, 233, 233); 
		border: 4px solid crimson; 
		padding: 25px; 
		max-width: 780px; 
		display: block;
		display: none;
		margin:auto;
		margin-top: 15px
	}
	.done{
		color: green;
		background: rgba(221, 246, 221, 0.61); 
		border: 4px solid olive;
		margin-top: 10em;
	}
</style>
</head>
</head>

<body>
	<div class="container">

	  <div id="steps">
	  		<span id="step-1" class="step active">1</span>
	  		<span id="step-2" class="step">2</span>
	  		<span id="step-3" class="step">3</span>
	  </div>	

	  <p class="msg"></p>

      <form class="form-signin" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
       <div class="step-data active">
	       <h2 class="form-signin-heading">Step 1: Permissions Check</h2>
	        <?php
					error_reporting(0);
					$ok = array();
					
					if (function_exists('mysqli_connect')) {
						echo "<div><strong>MySQLi Support</strong> <span style='color:green;'>is OK!</span></div>";
						$ok[0] = true;
					} else {
						echo "<div><strong>MySQLi Support</strong> <span style='color:red;'>The MySQLi extension must be enabled.</span></div>";
					}
					if(is_dir("../upload/") && is_writable("../upload/")) {
						echo "<div class='item'><strong>admin/upload/</strong> <span style='color:green;'>is writable - OK!</span></div>";
						$ok[1] = true;
					} else {
						echo "<div><strong>../upload/</strong> <span style='color:red;'>must be writable.</span></div>";
					}
					if(is_dir("../inc/") && is_writable("../inc/")) {
						echo "<div class='item'><strong>admin/inc/</strong> <span style='color:green;'>is writable - OK!</span></div>";
						$ok[2] = true;
					} else {
						echo "<div><strong>../inc/</strong> <span style='color:red;'>must be writable.</span></div>";
					}
					if( is_writable("../inc/config.php") ) {
						echo "<div class='item'><strong>admin/inc/config.php</strong> <span style='color:green;'>is writable - OK!</span></div>";
						$ok[3] = true;
					} else {
						echo "<div><strong>admin/inc/config.php</strong> <span style='color:red;'>must be writable.</span></div>";
					}
			?>		
			<?php if ($ok[0] && $ok[1] && $ok[2] && $ok[3]): ?>
	        <div class="btn btn btn-primary-outline btn-block next">Next</div>
	         <?php else: echo "Please correct the above errors to continue."; endif; ?>
       </div>	
       <div class="step-data">
	       <h2 class="form-signin-heading">Step 2: Database Setup</h2>
	        <label for="host">Database Host</label>
	        <input type="text" name="host" id="host" class="form-control" required autofocus>
	        <label for="dbname">Database Name</label>
	        <input type="text"  name="dbname" id="dbname" class="form-control" required>
	        <label for="dbuser">Database User</label>
	        <input type="text"  name="dbuser" id="dbuser" class="form-control" required>
	        <label for="dbpass">Database Password</label>
	        <input type="text"  name="dbpass" id="dbpass" class="form-control" required>
	        <div class="btn btn btn-primary-outline btn-block next">Next</div>
       </div>
       <div class="step-data">
	       <h2 class="form-signin-heading">Step 3: Create Admin Account</h2>
	        <label for="username">Choose Admin Username</label>
	        <input type="text" name="username" id="admin" class="form-control" placeholder="Username" required autofocus>
	        <label for="password">Choose Admin Password</label>
	        <input type="password"  name="password" id="inputPassword" class="form-control" placeholder="Password" required>
	        <label for="password">Repeat Password</label>
	        <input type="password"  name="rpassword" id="rinputPassword" class="form-control" placeholder="Password Again" required>
	        <div class="btn btn btn-primary-outline btn-block" type="submit" id="subm" name="Submit" >Install</div>
       </div>
      </form>

	</div> <!-- /container -->

<script type="text/javascript" src="../assets/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../assets/js/install.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
</body>
</html>

<?php
 } else if( $step === '1' ) { 
	$hostname = ( isset($_POST['host']) ? trim($_POST['host']) : 'localhost' );
	$username = isset($_POST['dbuser']) ? trim($_POST['dbuser']) : '';
	$password = isset($_POST['dbpass']) ? trim($_POST['dbpass']) : '';
	$database = isset($_POST['dbname']) ? trim($_POST['dbname']) : '';
	$fail = array();
	$connect = @new mysqli($hostname, $username, $password, $database);
	if (mysqli_connect_errno()) {
		echo 'Error accessing the MySQL database. Check your information';
		echo 'FAIL';
	} else {
		echo 'DONE';
		$config_file = '<?php
		/**
		 * ContentLock
		 * Developed by themeflection
		 */
		 
		//
		// Please configure the following MySQL settings
		$DB_HOST = "' . trim($_POST['host']) . '";
		$DB_USER = "' . trim($_POST['dbuser']) . '";
		$DB_PASS = "' . trim($_POST['dbpass']) . '";
		$DB_NAME = "' . trim($_POST['dbname']) . '";
		
		$installed = true;
	?>';
		
		$write_config = fopen("../inc/config.php", "w+");
		fwrite($write_config, $config_file);
		fclose($write_config);
	
	}
	
 } else if( $step === '2' ) {
 	$username = isset($_POST['user']) ? trim($_POST['user']) : ''; 
	$password = isset($_POST['pass']) ? trim($_POST['pass']) : '';
	$rpassword = isset($_POST['rpass']) ? trim($_POST['rpass']) : '';
	$options = array('cost' => 7);
	if( $password && $username && $password === $rpassword ) {
	 	include( '../inc/config.php' ); 
	 	include( '../inc/password.php' ); 
		$password =  password_hash($password, PASSWORD_BCRYPT, $options);
	 	$connect = @new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
	 	if ( !mysqli_connect_errno() ) {
		 	$username = $connect->real_escape_string($username);
	 		// install admin table
			$connect->query("CREATE TABLE IF NOT EXISTS `admin` (
			  `name` varchar(20) NOT NULL,
			  `pass` varchar(500) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1");
			
			// default data
			$connect->query("INSERT INTO `admin` (`name`, `pass`) VALUES
			('$username', '$password')");		

			// insert locks table
			$connect->query("CREATE TABLE IF NOT EXISTS `locks` (
			  `id` int(4) NOT NULL AUTO_INCREMENT,
			  `lock_id` varchar(20) NOT NULL,
			  `group` varchar(20) NOT NULL,
			  `password` varchar(30) NOT NULL,
			  `stats` int(20) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");

			// insert unlocks table
			$connect->query("CREATE TABLE IF NOT EXISTS `unlocks` (
			  `id` int(4) NOT NULL AUTO_INCREMENT,
			  `lock_id` varchar(20) NOT NULL,
			  `group` varchar(20) NOT NULL,
			  timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");

	 		// insert subscribers table
			$connect->query("CREATE TABLE IF NOT EXISTS `subscribers` (
			  `id` int(4) NOT NULL AUTO_INCREMENT,
			  `email` varchar(20) NOT NULL,
			  `refferer` varchar(20) NOT NULL,
			  `stats` int(20) NOT NULL DEFAULT '0',
			  timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");
	 		echo 'Instalation Complete';
	 		echo '<p>';
	 		echo '<span style="display: block; border: 1px solid #777; padding: 7px; margin: 10px 0">Your Username: <span style="color: #333">' . $username . '</span></span>';
	 		echo '<span style="display: block; border: 1px solid #777; padding: 7px">Your Password: <span style="color: #333">' . trim($_POST['pass']) . '</span></span>';
	 		echo '</p>';
	 		echo "<br/> You can now login to the <a href='../index.php'>Admin Area</a>";
	 		unlink("install.txt");
	 		$connect->close();
	 	} 
 	} else {
 		echo 'Passwords do not match.';
 		echo 'FAIL';
 	}
 }

?>