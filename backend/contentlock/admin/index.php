<?php
session_start();

if (isset($_POST['username'])) {
	
	include_once __DIR__ . '/auth.php';
	
}
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
    <link rel="icon" href="../favicon.ico">

    <title>Login | ContentLock</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
     <!-- Main Login CSS -->
    <link href='assets/css/login.css' rel='stylesheet' type='text/css'>
    <!-- Roboto Font -->
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>


<body>
<div class="container">
<?php if( !file_exists('install/install.txt') ) : ?>
      <form class="form-signin" action="index.php" method="post" enctype="multipart/form-data">
        <img src="assets/images/login.png" alt="login" />
        <h2 class="form-signin-heading">Dashboard Login</h2>
        <label for="inputEmail" class="sr-only">Username</label>
        <input type="text" name="username" id="inputEmail" class="form-control" placeholder="Username" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password"  name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <button class="btn btn-primary btn-block" type="submit" name="Submit" >Sign in</button>
      </form>
      <br/>
      <p style="text-align: center"><em>Forgot Your Password?</em> Reset it <a href="pages/reset.php" style="color: yellow">here</a></p>
<?php else: 
   echo "<p style='color: indianred; background: rgb(254, 233, 233); border: 4px solid crimson; padding: 25px; max-width: 780px; display: block;margin:auto'>You have not installed this script yet. Please install admin area first by going to <a href='". dirname($_SERVER['HTTP_HOST']) ."/install/install.php'>this</a> link. <br/> <strong></p>";
 endif; ?>
</div> <!-- /container -->

</body>
</html>