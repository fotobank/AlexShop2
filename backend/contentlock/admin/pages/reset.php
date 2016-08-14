<?php

	include( '../inc/config.php' ); 
 	$connect = @new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
 	$data = '';
 	if ( !mysqli_connect_errno() ) {
 		$sql = "SELECT * FROM settings";
    $sql2 = "SELECT * FROM admin";
		$data = $connect->query($sql);
    $data2 = $connect->query($sql2);
    $name = '';
    $options = array('cost' => 7);
    $psw = substr(md5(rand()), 0, 9);
    $password =  password_hash($psw, PASSWORD_BCRYPT, $options);
    $headers = "From: ContentLock" . PHP_EOL;
    $msg  = 'Your new ContentLock Admin Dahsboard Password: ' . $psw . PHP_EOL;
    $msg .= 'You can change this password after you login from <Settings> section' . PHP_EOL;
    foreach( $data2 as $row ) { 
       $name = $row['name'];
    }
    foreach( $data as $row ) {
      if( $row['mail'] ) {
        $suc = $connect->prepare("UPDATE `admin` SET `pass` = ? WHERE `name`=?");
        $suc->bind_param('ss', $password, $name);
        $suc->execute();
        if( !$suc ) {
          echo '<p style="color: crimson">Error connecting to the database</p>';
        }
        if( mail( $row['mail'], 'Password Reset', $msg, $headers ) ) {
          echo '<p style="display: block; max-width: 400px; width: 100%; margin: auto; border: 3px solid olive; background: lightgreen; color: green; padding: 20px">You new password has been sent successfully. Check your admin email inbox.</p>';
        } else {
          echo '<p style="color: crimson">Sorry, email couldn\'t be delivered at this time.</p>';
        }
        $suc->close();
        $connect->close();
      }
    }

 	} else {
 		echo 'Error connecting to database.';
 	}

?>