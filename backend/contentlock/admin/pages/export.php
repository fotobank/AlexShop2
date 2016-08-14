<?php
session_start();
error_reporting(E_ALL);

if (isset($_SESSION['id'])):
	include( '../inc/config.php' ); 
 	$connect = @new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
 	$data = '';
 	if ( !mysqli_connect_errno() ) {
 		$sql = "SELECT * FROM locks";
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
                 <h1 class="page-header"><img class="icn" src="../assets/images/export.png" alt="icon" />Export Data</h1>
    	     	  </div>
          </div>    
          <div class="row">
  	     		 <div class="col-md-5">
  	 				    <h4>Export ContentLock Data</h4>
      		 			 <div>
                      <p>You can download all your ContentLock data as single xml file for backup. It can be easily imported later.</p>
      		 			 	    <button class="btn btn-primary" id="export">Export</button>
      		 			 </div>
  	 			   </div> 
    	 			<div class="col-md-7">
    	 				<p></p>
    	 			</div>
        </div>
     </div>
  </div>

  <?php include('inc/footer.php'); ?>

<?php else:  ?>
  <p style='color: indianred; background: rgb(254, 233, 233); border: 4px solid crimson; padding: 25px; max-width: 780px; display: block;margin:auto'>You are not authorized to be here.</p>
<?php endif; ?>