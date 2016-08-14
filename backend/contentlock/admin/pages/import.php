<?php
session_start();
error_reporting(E_ALL);

if (isset($_SESSION['id'])):
  if( isset($_POST['import']) ){
	   include_once( '../inc/functions.php' );
     include( '../inc/config.php' ); 
     Import($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
  } 
?>
<?php include('inc/head.php'); ?>

  <?php include('inc/sidebar.php'); ?>

  <div id="page-wrapper" >
      <div id="page-inner">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="page-header"><img class="icn" src="../assets/images/import.png" alt="icon" />Import Data</h1>
    	     	  </div>
          </div>    
          <div class="row">
    	     		<form class="col-md-5" action="../inc/functions.php" method="POST" id="upload" enctype="multipart/form-data">
      	 				 <h4>Import ContentLock Data</h4>
      		 			 <div>
                    <p>Select xml file from your computer to import.</p>
        		 			 	<input style="display: block; margin-bottom: 20px" type="file" name="xml" />
                    <button class="btn btn-primary" id="import" name="import">Import</button>
      		 			 </div>

                 <div id="progress">
                    <div id="bar"></div>
                    <div id="percent">0%</div >
                 </div>  
              </form>     

      	 			<div id="result" class="col-md-7">
      	 				<p></p>
      	 			</div>
   			  </div> 
      </div>
  </div>

  <?php include('inc/footer.php'); ?>

<?php else:  ?>
  <p style='color: indianred; background: rgb(254, 233, 233); border: 4px solid crimson; padding: 25px; max-width: 780px; display: block;margin:auto'>You are not authorized to be here.</p>
<?php endif; ?>