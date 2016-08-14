<?php
session_start();
error_reporting(E_ALL);

if (isset($_SESSION['id'])):
	$name = $_SESSION['username'];
	include( '../inc/config.php' ); 
 	$connect = @new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
 	$data = '';
 	if ( !mysqli_connect_errno() ) {
 		$sql = "SELECT * FROM locks";
 		$sql2 = "SELECT * FROM locks WHERE group != 'none'";
		$data = $connect->query($sql);

 	} else {
 		echo 'Error connecting to database.';
 	}

?>
 <?php include('inc/head.php'); ?>

  <?php include('inc/sidebar.php'); ?>

  <div id="page-wrapper" >
      <div id="page-inner">
          <div class="row">
              <div class="col-md-12">
          		 <h1 class="page-header"><img class="icn" src="../assets/images/lock.png" alt="icon" />Group Lock Passwords</h1>
	     	  </div>
	      </div>	  	
	      <div class="row">
     		<div class="col-md-5">
 				 <h4>Add New</h4>
	 			 <div class="group-lock">
	 			 	<input type="text" placeholder="Group Lock-ID" required />
	 			 	<input type="text" placeholder="Password" required />
	 			 	<button class="btn btn-primary save">Save</button>
	 			 </div>
 			</div> 
 			<div class="col-md-7 group">
 				<h4>Currently Added</h4>
 				<?php 
 					$n = false;
		     	   if( ( $data ) ):
	 				foreach($data as $row): 
	 					if( $row['group'] != 'none' ):
	 					$n = true;
	 			 ?>
	 			 <div class="single-lock" data-id="<?php echo $row['id']; ?>">
	 			 	<span>
	 			 		Group ID:
	 			 		<?php echo $row['group']; ?>
	 			 	</span>
	 			 	<span>
	 			 		Password:
	 			 		<?php echo $row['password']; ?>
	 			 	</span>
	 			 	<b class="remove">X</b>
	 			 </div>
	 			<?php endif; endforeach; endif; ?> 
	 			 <?php if( !$n ): ?>
	 			 	<p>No group lock added yet. Enter Group Lock-ID, assign it a password and click save button to create new lock.</p>
	 			 <?php endif; ?>
 			</div>
		 </div> 
      </div>
  </div>
  <?php include('inc/footer.php'); ?>

<?php else:  ?>
  <p style='color: indianred; background: rgb(254, 233, 233); border: 4px solid crimson; padding: 25px; max-width: 780px; display: block;margin:auto'>You are not authorized to be here.</p>
<?php endif; ?>