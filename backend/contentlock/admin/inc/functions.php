<?php

 // include database information, password hash
 // and swiftmailer library	
 require( 'config.php' ); 
 require( 'password.php' );
 require_once 'swiftmailer/swift_required.php'; 

 // database information
 define( 'DB_NAME', $DB_NAME );
 define( 'DB_HOST', $DB_HOST );
 define( 'DB_USER', $DB_USER );
 define( 'DB_PASS', $DB_PASS );
 //settings array that will hold email information
 $settings = setSettings();
 
 /**
 * Get values from `settings` table for later use.
 * 
 * @package ContentLock
 * @return arrray
 * @since 1.0
 */
 function setSettings() {
 	$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
 	if ($con->connect_error) {
    	die("Connection failed: " . $con->connect_error);
	}

	$sql = "SELECT * FROM `settings`";
	$data = $con->query($sql);
 
	if( $data ) {
		foreach( $data as $row ) {
			$settings['smtp'] = $row['smtp'];
			$settings['port'] = (int) $row['port'];
			$settings['mail'] = $row['mail'];
			$settings['pass'] = $row['password'];	
			$settings['sname'] = $row['sname'];
		}
	} else {
		$settings = array();
	}
	$con->close();
	return $settings;
 }

 /**
 * Ajax Calls.
 * Get all values from ajax and call functions
 * according to 'action' which is passed via ajax call.
 * 
 * @package ContentLock
 * @since 1.0
 */
 if( isset( $_POST['action'] ) ) {
 	if( $_POST['action'] === 'single' ) {
 		saveSingle();
 	} else if( $_POST['action'] === 'group' ) {
 		saveGroup();
 	} else if( $_POST['action'] === 'one' ) {
 		singleMail($settings);
 	} else if( $_POST['action'] === 'mass' ) {
 		massMail($settings);
 	} else if( $_POST['action'] === 'remove' ) {
 		$type = isset( $_POST['type'] ) ? $_POST['type'] : '/';
 		remove($type);
 	} else if( $_POST['action'] === 'settings' ) {
 		settings();
 	} else if( $_POST['action'] === 'stats' ) {
 		$id = isset( $_POST['id'] ) ? $_POST['id'] : '/';
 		$type = isset( $_POST['type'] ) ? $_POST['type'] : '/';
 		increaseStats($id, $type);
 	} else if( $_POST['action'] === 'subs' ) {
 		$email = isset( $_POST['email'] ) ? $_POST['email'] : '';
 		$refferer = isset( $_POST['refferer'] ) ? $_POST['refferer'] : '';
 		$type = isset( $_POST['type'] ) ? $_POST['type'] : ''; 
 		subscribe($email, $refferer, $type, $settings);
 	} else if( $_POST['action'] === 'subsend' ) {
 		subsMail($settings);
 	} else if( $_POST['action'] === 'unlocked' ) {
 		$type = isset( $_POST['type'] ) ? $_POST['type'] : '';
 		$id = isset( $_POST['id'] ) ? $_POST['id'] : '';
 		unlockedStats($type, $id);
 	} else if( $_POST['action'] === 'subdown' ) {
 		saveSubscribers();
 	}
}
 
 //if backup uploaded call import function
 if( isset($_FILES["xml"]) ) {
 	if( $_FILES["xml"]["type"] == "text/xml" ) {
	 	//upload file
	 	$target_dir = "../upload/";
		$target_file = $target_dir . basename($_FILES["xml"]["name"]);
		 if (move_uploaded_file($_FILES["xml"]["tmp_name"], $target_file)) {
	        echo "The file ". basename( $_FILES["xml"]["name"]). " has been uploaded. <br/>";
	    } else {
	        echo "Sorry, there was an error uploading your file. <br/>";
	    }
		import($target_file);
	} else {
		echo '<span style="color: #800">You need to import from a valid .xml file</span>';
	}
 } 

 /**
 * Save single locks into `locks` table
 * 
 * @package ContentLock
 * @since 1.0
 */
 function saveSingle() {
 	$id = isset($_POST['id']) ? $_POST['id'] : '';
 	$pass = isset($_POST['pass']) ? $_POST['pass'] : '';
 	$none = 'none';

 	//connect to the database
 	$connect = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
 	if ($connect->connect_error) {
    	die("Connection failed: " . $connect->connect_error);
	}

	//check if id exists
	$sql = "SELECT * FROM locks";
	$rows = $connect->query($sql);
	$exists = false;
	foreach( $rows as $row ) {
		if( $row['group'] === $id || $row['lock_id'] === $id ) $exists = true;
	} 
	if( !$exists ) { 
	 	// add data
	 	$stmt = $connect->prepare("INSERT INTO `locks` (`lock_id`, `group`, `password`) VALUES
		(?,?,?)");
		$stmt->bind_param("sss", $id, $none, $pass);
		$stmt->execute();
		$stmt->close();
	} else {
		echo 'That Lock-ID already exists';
	}

 	$connect->close();
 }

 /**
 * Save group locks into `locks` table
 * 
 * @package ContentLock
 * @since 1.0
 */
 function saveGroup() {
 	$id = isset($_POST['id']) ? $_POST['id'] : '';
 	$pass = isset($_POST['pass']) ? $_POST['pass'] : '';
 	$none = '';

 	//connect to the database
 	$connect = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
 	if ($connect->connect_error) {
    	die("Connection failed: " . $connect->connect_error);
	}
	//check if id exists
	$sql = "SELECT * FROM locks";
	$rows = $connect->query($sql);
	$exists = false;
	foreach( $rows as $row ) {
		if( $row['group'] === $id || $row['lock_id'] === $id ) $exists = true;
	}
	if( !$exists ) { 
	 	// add data
		$stmt = $connect->prepare("INSERT INTO `locks` (`lock_id`, `group`, `password`) VALUES
		(?,?,?)");	
		$stmt->bind_param("sss", $none, $id, $pass);
		$stmt->execute();
		$stmt->close();
	} else {
		echo 'That Group-ID already exists';
	}

 	$connect->close();
 }

 /**
 * Remove records from locks table.
 * This is used for both single locks groups.
 * 
 * @param $type
 * @since 1.0
 */
 function remove($type) {
 	$id = isset($_POST['id']) ? (int) $_POST['id'] : ''; 

 	//connect to the database
 	$conn = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
 	if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
	}

	$sql['locks'] =  "DELETE FROM `locks` WHERE id=?";
	$sql['subs'] =  "DELETE FROM `subscribers` WHERE id=?";
	$stmt = $conn->prepare($sql[$type]);
	$stmt->bind_param("i", $id);
	$stmt->execute();

	//close connection
	$stmt->close();
	$conn->close();
 }

 /**
 * Function to send email to single contact.
 * Called when "Send to a single receiver" is selected
 * from <Send Password> section.
 * 
 * @package ContentLock
 * @param $settings
 * @since 1.0
 */
 function singleMail($settings = array()) {

 	//check if settings are set
 	if( !empty($settings) ){
	 	//connect to the database
		$connect = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
 		//get the email template
		$temp = $connect->query("SELECT `template` FROM `settings`"); 
		$template = '';
		foreach( $temp as $t ) {
			$template = $t['template'];
		}
		$connect->close();
	 	// Create the Transport
		$transport = Swift_SmtpTransport::newInstance($settings['smtp'], $settings['port'], 'ssl')
		  ->setUsername($settings['mail'])
		  ->setPassword($settings['pass']);

	 	//get the values
	 	$to = isset( $_POST['to'] ) ? trim( $_POST['to'] ) : '';
	 	$password = isset( $_POST['pass'] ) ? trim( $_POST['pass'] ) : '';
	 	$subject = isset( $_POST['subject'] ) ? $_POST['subject'] : 'Password';
	 	$from = $settings['sname'];

	 	if( isset( $_POST['email'] ) ) {
	 		$to = $_POST['email'];
	 	}

	 	if( isset( $_POST['refferer'] ) && isset( $_POST['type'] ) ){
	 		$id = $_POST['refferer'];
	 		$type = $_POST['type'];
	 		$password = returnPass($id, $type);
	 	} 
	 	
	 	if( $template )  {
	 		$s = strpos( $template, '{' );
			$template = substr_replace($template, $password, $s, 11);
		}

	 	//create new instance
		$mailer = Swift_Mailer::newInstance($transport);
		$message = Swift_Message::newInstance();
		$message->setFrom(array($settings['mail'] => $from));
	 	$message->setTo($to);
		$message->setSubject($subject);
		$message->setBody($template, 'text/html'); 
		$result = $mailer->send($message);

		//increase statistics for subscriber (if exists)
		subStats($to);

		echo $result ? $result : 0;
	}
 }

 /**
 * Function to send email to multiple contacts.
 * Called when "Send to multiple receivers" is selected
 * from <Send Password> section.
 * 
 * @package ContentLock
 * @param $settings
 * @since 1.0
 */
 function massMail($settings = array()) {

 	if( !empty($settings) ){
	 	//connect to the database
		$connect = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
 		//get the email template
		$temp = $connect->query("SELECT `template` FROM `settings`");
		$template = '';
		foreach( $temp as $t ) {
			$template = $t['template'];
		}
		$connect->close();
	 	// Create the Transport
		$transport = Swift_SmtpTransport::newInstance($settings['smtp'], $settings['port'], 'ssl')
		  ->setUsername($settings['mail'])
		  ->setPassword($settings['pass']);

		//get the values
	 	$to = isset( $_POST['to'] ) ? trim( $_POST['to'] ) : '';
	 	$password = isset( $_POST['pass'] ) ? trim( $_POST['pass'] ) : '';
	 	$subject = isset( $_POST['subject'] ) ? $_POST['subject'] : 'Password';
	 	$from = $settings['sname'];  
	 	if( $template )  {
	 		$s = strpos( $template, '{' );
			$template = substr_replace($template, $password, $s, 11);
		}
	 	$list = explode("\n", $to); 

	 	//create new instance
		$mailer = Swift_Mailer::newInstance($transport);
		$message = Swift_Message::newInstance();
		$message->setFrom(array($settings['mail'] => $from));
		$message->setSubject($subject);
		foreach( $list as $k => $v) {
			$message->addBcc($v);
			subStats($v);
		}
		$message->setBody($template, 'text/html'); 
		$result = $mailer->send($message);

		echo $result ? $result : 0;
	}
 }

 /**
 * Function to send email to all subscribers.
 * Called when "Send to all subscribers" is selected
 * from <Send Password> section.
 * 
 * @package ContentLock
 * @param $settings
 * @since 1.0
 */
  function subsMail($settings = array()) {
 	//connect to the database
	$connect = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	//get all data from locks table
	$sql = "SELECT * FROM subscribers";
	$temp = $connect->query("SELECT `template` FROM `settings`");
	$rows = $connect->query($sql);
	$template = '';
	foreach( $temp as $t ) {
		$template = $t['template'];
	}
	$connect->close();

 	if( !empty($settings) ){

 		if( $rows ) {
		 	// Create the Transport
			$transport = Swift_SmtpTransport::newInstance($settings['smtp'], $settings['port'], 'ssl')
			  ->setUsername($settings['mail'])
			  ->setPassword($settings['pass']);

			//get the values
		 	$password = isset( $_POST['pass'] ) ? trim( $_POST['pass'] ) : '';
		 	$subject = isset( $_POST['subject'] ) ? $_POST['subject'] : 'Password';
		 	$from = $settings['sname'];  
		 	if( $template )  {
		 		$s = strpos( $template, '{' );
				$template = substr_replace($template, $password, $s, 11);
			}

		 	//create new instance
			$mailer = Swift_Mailer::newInstance($transport);
			$message = Swift_Message::newInstance();
			$message->setFrom(array($settings['mail'] => $from));
			$message->setSubject($subject);
			foreach( $rows as $row) {
				$message->addBcc($row['email']);
				subStats($row['email']);
			}
			$message->setBody($template, 'text/html'); 
			$result = $mailer->send($message);

			echo $result ? $result : 0;
		} else {
			echo 'You do not have any subscriber yet';
		}
	}
 }

 /**
 * Return password for single lock, or group ID.
 * 
 * @package ContentLock
 * @param $id, $type
 * @return string
 * @since 1.0
 */
 function returnPass($id, $type) {
 		//connect to the database
 		$connect = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

 		//get all data from locks table
 		$sql = "SELECT * FROM locks";
 		$rows = $connect->query($sql);
 		if( $type === 'cl' ) {
 			$type = 'lock_id'; 
 		} else {
 			$type = 'group';
 		}
 		foreach( $rows as $row ){ 
 			if( $row[$type] === $id ) 
 				return $row['password'];
 		} 
 		$connect->close();
 }

 /**
 * Update `stats` column in the `subscribers` table.
 * This function is called every time email is sent,
 * either when user subscribes for automatic password
 * or when user sends email(s) from <Send password> section. 
 * 
 * @package ContentLock
 * @param $email
 * @since 1.0
 */
 function subStats($email) {
 		//connect to the database
 		$connect = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

 		//get current stats from subscriber
 		$sql = "SELECT * FROM `subscribers`";
 		$rows = $connect->query($sql);
 		if( $rows ) {
 			foreach( $rows as $row ) {
 				if( $row['email'] === $email ){
 					$stats = $row['stats'] + 1; 
 					$stmt = $connect->prepare("UPDATE `subscribers` SET `stats` = ? WHERE `id` = ?");
					$stmt->bind_param("ii", $stats, $row['id']);
					$stmt->execute();
					
					//close connection
					$stmt->close();
 				}
 			}
	 		
 		}
 		$connect->close();
 }

 /**
 * Function for saving/updating user settings
 * 
 * @package ContentLock
 * @since 1.0
 */
 function settings() {
 		$sname = isset( $_POST['sname'] ) ? $_POST['sname'] : '';
 		$mail = isset( $_POST['mail'] ) ? $_POST['mail'] : '';
 		$smtp = isset( $_POST['smtp'] ) ? $_POST['smtp'] : 'smtp.gmail.com';
 		$pass = isset( $_POST['pass'] ) ? $_POST['pass'] : '';
 		$port = isset( $_POST['port'] ) ? $_POST['port'] : 465;
 		$template = isset( $_POST['template'] ) ? $_POST['template'] : '';
 		$psw = isset( $_POST['psw'] ) ? $_POST['psw'] : '';
 		$psw2 = isset( $_POST['psw2'] ) ? $_POST['psw2'] : '';

 		$connect = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

 		//check if settings table exists
 		$sql = "SELECT * FROM settings";
 		if( $connect->query($sql) ) {
 			//update values
			$stmt = $connect->prepare("UPDATE settings SET mail = ?, smtp = ?, password = ?, port = ?, sname = ?, template = ? WHERE id=1");
			$stmt->bind_param("sssiss", $mail, $smtp, $pass, $port, $sname, $template);
			//$stmt->execute();
			if( $stmt->execute() ) {
				echo 'Settings Saved Successfully.';
			} else {
				echo "Error updating record: " . $connect->error;
			}
			//close connection
			$stmt->close();
 		} else {
 			//create database and insert values
 			$connect->query("CREATE TABLE IF NOT EXISTS `settings` (
	 		  `id` int(4) NOT NULL,
	 		  `sname` varchar(20) NOT NULL,
			  `mail` varchar(20) NOT NULL,
			  `smtp` varchar(20) NOT NULL,
			  `password` varchar(30) NOT NULL,
			  `port` int(20) NOT NULL,
			  `template` varchar(128) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1");

			//insert values
			$stmt = $connect->prepare("INSERT INTO `settings` (`id`, `sname`, `mail`, `smtp`, `password`, `port`, `template`) VALUES
			(?, ?, ?, ?, ?, ?, ?)");
			$id = 1;
			$stmt->bind_param("issssis", $id, $sname, $mail, $smtp, $pass, $port, $template);
			

			if( $stmt->execute() ) 
				echo 'Settings Saved Successfully.';

			//close connection
			$stmt->close();
	 	}

	 	//check password
	 	if( $psw && $psw2 ) {
	 		session_start();
	 		$options = array('cost' => 7);
	 		$name = $_SESSION['username'];
	 		if( $psw === $psw2 ) {
	 			$password = password_hash($psw, PASSWORD_BCRYPT, $options);
	 			$stmt = $connect->prepare("UPDATE admin SET pass = ? WHERE name=?");
	 			$stmt->bind_param("ss", $password, $name);
	 			if( $stmt && $stmt->execute() ) {
	 				echo " <br/>Password Saved Successfully"; 
	 				$stmt->close();
	 			}
	 		} else {
	 			echo ' <br/><span style="color: crimson"> But Password was not Saved. Password Did not match.</span>';
	 		}
	 	} else if( $psw && !$psw2 || !$psw && $psw2 ){
 			echo ' <br/><span style="color: crimson"> But Password was not Saved. Password Did not match.</span>';
 		}

		//close connection
		$connect->close();
 }

 /**
 * Export ContentLock Data (Locks and subscribers)
 * 
 * @package ContentLock
 * @since 1.0
 */
 function export() {

 	//connect to database
 	$connect = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	//get all data from locks table
	$sql = "SELECT * FROM locks";
	$data = $connect->query($sql);

	//get all data from locks table
	$sql2 = "SELECT * FROM subscribers";
	$subs = $connect->query($sql2);

	if( $data || $subs ) {

		$domtree = new DOMDocument('1.0', 'UTF-8');

	    $xmlRoot = $domtree->createElement("xml");
	    $xmlRoot = $domtree->appendChild($xmlRoot);

		foreach( $data as $row ) {

		    $lock = $domtree->createElement("lock");
		    $lock = $xmlRoot->appendChild($lock);

		    $lock->appendChild($domtree->createElement('lock_id',$row['lock_id']));
		    $lock->appendChild($domtree->createElement('password',$row['password']));
		    $lock->appendChild($domtree->createElement('group',$row['group']));
		    $lock->appendChild($domtree->createElement('stats',$row['stats']));

		}

		foreach( $subs as $sub ) {
			$lock = $domtree->createElement("subscriber");
		    $lock = $xmlRoot->appendChild($lock);

		    $lock->appendChild($domtree->createElement('email',$sub['email']));
		    $lock->appendChild($domtree->createElement('refferer',$sub['refferer']));
		    $lock->appendChild($domtree->createElement('stats',$sub['stats']));
		}

		$file = 'backup_'.date('j-m-y').'.xml'; 
	    /* get the xml printed */
	    header("Content-type:text/xml; charset=utf-8");
		header("Content-Disposition: attachment; filename=".$file); 
	    echo $domtree->saveXML();
	} else if( !$data && !$subs ) {
		echo 'You do not have any content created yet.';
	}
	$connect->close();
 }

 /**
 * Import ContentLock data into database
 * 
 * @package ContentLock
 * @param $file
 * @since 1.0
 */
 function Import($file) {

 	if( $file ) {

 		$xml = $file;

	 	//connect to database
	 	$connect = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	 	$sql = "SELECT * FROM locks";
	 	//get subscribers
	 	$sbs = "SELECT * FROM subscribers";

	 	//get data from locks table
	 	$data = $connect->query($sql);
	 	//get data from subscribers table
	 	$sbcs = $connect->query($sbs);

	 	if( !$data ) {
		 	// insert locks table if it doesn't exist
			$connect->query("CREATE TABLE IF NOT EXISTS `locks` (
			  `id` int(4) NOT NULL AUTO_INCREMENT,
			  `lock_id` varchar(20) NOT NULL,
			  `group` varchar(20) NOT NULL,
			  `password` varchar(30) NOT NULL,
			  `stats` int(20) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");
		} 
		
		//load xml file	
		$doc = new DOMDocument('1.0', 'UTF-8'); 
		$doc->load($xml);
		$locks = $doc->getElementsByTagName( "lock" );
		$subs = $doc->getElementsByTagName( "subscriber" );
		$n = $b = 0;
		$total = $locks->length;
		$total += $subs->length;
		echo 'total:' . $total . '|total'; 
		foreach( $locks as $lock ) { 

		    $xmlLock = $lock->getElementsByTagName( "lock_id" );
		    $lock_id = $xmlLock->item(0)->nodeValue;

		    $xmlPass = $lock->getElementsByTagName( "password" );
		    $pass = $xmlPass->item(0)->nodeValue;

		    $xmlGroup = $lock->getElementsByTagName( "group" );
		    $group = $xmlGroup->item(0)->nodeValue;

		    $xmlStats = $lock->getElementsByTagName( "stats" );
		    $stats = $xmlStats->item(0)->nodeValue;

		    //insert into databse
		    $imp = '';
		    $stmt = $connect->prepare("SELECT id FROM `locks` WHERE `lock_id` = ? AND `group` = ?"); 
		    if( $stmt ) {
			    $stmt->bind_param("ss", $lock_id, $group);
			    $stmt->execute();
			    $stmt -> bind_result($result);
			    $stmt -> fetch();
			    if( !$result ) {
				    $imp = $connect->prepare("INSERT INTO `locks` (`lock_id`, `group`, `password`, `stats`) VALUES (?,?,?,?)");
					$imp->bind_param("sssi", $lock_id, $group, $pass, $stats);
				} else {
					echo 'Lock exists<br/>';
				}
		    }
		    
		    //display success/error message when finished	
			if( $imp && $imp->execute() ) {
				echo 'Lock Data Inserted Successfully...<br/>';
				$n++;
				$imp->close();
			} else if(!$imp) { 
				continue;
			} else {
				echo 'Could not connect to database ' . $connect->connect_error;
			}
			$stmt->close();
		} 

		if( $subs ) echo '<br/>Inserting Subscribers...<br/>';
		//insert subscribers
		foreach( $subs as $sub ) { 

		    $xmlLock = $sub->getElementsByTagName( "email" );
		    $email = $xmlLock->item(0)->nodeValue;

		    $xmlPass = $sub->getElementsByTagName( "refferer" );
		    $reff = $xmlPass->item(0)->nodeValue;

		    $xmlGroup = $sub->getElementsByTagName( "stats" );
		    $stats = $xmlGroup->item(0)->nodeValue;

		     //insert into databse
		    $imp = '';
		    $stmt = $connect->prepare("SELECT id FROM `subscribers` WHERE `email` = ?"); 
		    if( $stmt ) {
			    $stmt->bind_param("s", $email);
			    $stmt->execute();
			    $stmt -> bind_result($result);
			    $stmt -> fetch();
			    if( !$result ) {
				    $imp = $connect->prepare("INSERT INTO `subscribers` (`email`, `refferer`, `stats`) VALUES (?,?,?)");
					$imp->bind_param("ssi", $email, $reff, $stats);
				} else {
					echo 'Subscriber exists<br/>';
				}
		    }
			
		    //display success/error message when finished
			if( $imp && $imp->execute() ) {
				echo 'Subscriber Inserted Successfully...<br/>';
				$b++;
			} else if(!$imp) { 
				continue;
			} else {
				echo 'Could not connect to database ' . $connect->connect_error;
			}
			$stmt->close();
		} 
		$connect->close();
		echo '<br/><span style="color: steelblue">'. $n .' Lock Data Rows Inserted.</span>';
		echo '<br/><span style="color: steelblue">'. $b .' Subscribers Inserted.</span>';
		echo '<br/><span style="color: olive">ContentLock Data Imported Successfully.</span>';	
	} 

 }

 /**
 * Function for increasing single and group lock
 * stats every time they are unlocked.
 * 
 * @package ContentLock
 * @param $id, $type
 * @since 1.0
 */
 function increaseStats($id, $type) { 
 	$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
 	$sql = "SELECT * FROM `locks`";
 	//get all data from database
 	$rows = $con->query($sql);

 	foreach( $rows as $row ) {
 		if( $row[$type] === $id ) {
 			$stats = $row['stats'] + 1;
	 		$suc = $con->prepare("UPDATE `locks` SET `stats` = ? WHERE `id` = ?");
			$suc->bind_param("ii", $stats, $row['id']);
			if( $suc ) $suc->execute();
 		}
 	}
	$con->close();
 }

 /**
 * Insert new value into `unlocks` table.
 * This function gets called every time a lock gets
 * unlocked. It stores ID of the singel or group lock
 * and timestamp - the date on which it is unlocked.
 * 
 * @package ContentLock
 * @param $type, $id
 * @since 1.0
 */
 function unlockedStats($type, $id) {
 	$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
 	$sql = "INSERT INTO `unlocks` (`$type`) VALUES ('$id')";
 	//insert new value into unlocks table
 	$con->query($sql);
 	$con->close();
 }

 /**
 * Function that gets called once user subscribes
 * in order to receive password for the selected lock/group ID.
 * 
 * @package ContentLock
 * @param $email, $refferer, $type, $settings
 * @since 1.0
 */
 function subscribe($email, $refferer, $type, $settings) { 
 	if( $email && $refferer && $type ) {
 		if( $type === 'cl' ) {
 			$refferer = 'Lock-ID: ' . $refferer;
 		} else {
 			$refferer = 'Group Lock-ID: ' . $refferer;
 		}
	 	include('config.php');
	 	$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	 	$check = "SELECT * FROM subscribers";
	 	$exists = false;
	 	$rows = $con->query($check);
	 	foreach( $rows as $row ) {
	 		if( $row['email'] === $email ) $exists = true;
	 	}
	 	if( !$exists ) {
		 	$sql = "INSERT INTO `subscribers` (`email`, `refferer`) VALUES (?,?)";
		 	$stmt = $con->prepare($sql);
		 	$stmt->bind_param("ss", $email, $refferer);
		 	$stmt->execute();
		 	$stmt->close();
		 }
	 	$con->close();
	 	singleMail($settings);
	 	echo 'DONE';
 	}
 }	

/**
 * Generate list of the current subscribers and 
 * save them as .txt file for download.
 * 
 * @package ContentLock
 * @since 1.0
 */
 function saveSubscribers() {
 	$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
 	$sql = "SELECT `email` FROM `subscribers`";
 	$rows = $con->query($sql);
 	$file = '';
 	foreach( $rows as $row ) {
 		$file .= $row['email'] . PHP_EOL;
 	}
 	 $con->close();
    header("Content-type:text/plain; charset=utf-8");
	header("Content-Disposition: attachment; filename=subscribers.txt"); 
	echo $file;
 }

?>