<?php
session_start();
error_reporting(E_ALL);

if (isset($_SESSION['id'])):
	$name = $_SESSION['username'];
	include( '../inc/config.php' ); 
 	$connect = @new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
  $settings = false;
 	$data = '';
 	if ( !mysqli_connect_errno() ) {
 		$sql = "SELECT * FROM locks";
		$data = $connect->query($sql);
    $sql2 = "SELECT * FROM settings";
    $settings = $connect->query($sql2);
    $connect->close(); 
 	} else {
 		echo 'Error connecting to database.';
 	}
?>
  <?php include('inc/head.php'); ?>

  <?php include('inc/sidebar.php'); ?>

  <div id="page-wrapper" >
      <div id="page-inner">
          <div class="row">
              <?php if( $settings ): ?>
                <div class="col-md-9 col-xs-12">
                	<h1 class="page-header"><img class="icn" src="../assets/images/send.png" alt="icon" />Email password to contact(s)</h1>
                	 <div class="mailing">
                		 <h4>Send password for:</h4>
                  		<div class="fls">
                  			<select>
                  				<option>Select type...</option>
                  				<option data-id="id">Lock-ID</option>
                  				<option data-id="group">Group</option>
                  			</select>
                  			<select class="id">
                				<?php
                				 $exs = false;
      		            	if ($data->num_rows > 0) :
      		            	 foreach($data as $row):
      		            	 	if( $row['group'] === 'none' ):
      		            	 		$exs = true;
      		                ?>
      			                <option data-id="<?php echo $row['password']; ?>"><?php echo $row['lock_id']; ?></option>		         
          		         	  <?php endif; endforeach; endif; ?>
          		         	  <?php if( !$exs ): ?>
          		         	 		<option>You have not created any single lock yet</option>
          		         	  <?php endif; ?>
                    			</select>  
                		    	<select class="group">
                  				<?php
                  				 $exs = false;
        		            	if ($data->num_rows > 0) :
        		            	 foreach($data as $row):
        		            	 	if( $row['group'] != 'none' ):
        		            	 		$exs = true;
        		             ?>
      			                <option data-id="<?php echo $row['password']; ?>"><?php echo $row['group']; ?></option>		         
          		         	  <?php endif; endforeach; endif; ?>
          		         	  <?php if( !$exs ): ?>
          		         	 		<option>You have not created any group lock yet</option>
          		         	  <?php endif; ?>
                    			</select>  
                		  </div>
                  		<h4>To:</h4>
                  		<h4>Single Recepient</h4>
                  		<div class="one">
                  		  <label>Enter Receipent Email
                  			<input type="email" />
                  		  </label>	
                  		  <button class="btn btn-success">Send Password</button>
                  		</div>

                      <div class="row">
                    		<h4>Multiple Recepients </h4>
                    		<div class="mass col-md-8 col-xs-12">
                    		   <label>Enter Receipents <button type="button" class="btn btn-default tltp2" data-toggle="tooltip" data-placement="top" title="Send a password for selected lock/or group ID to the list of recepients. You need to separate every contact you insert with <enter> in order to send emails successfuly."><i class="fa fa-question"></i></button></label>	
                    		   <textarea placeholder="Paste space separated list of emails (paste contact then hit enter - you must press enter after every contact input)"></textarea>
                    		   <button class="btn btn-success">Send Password</button>
                    		</div>

                        <div class="sbsend col-md-4 col-xs-12">
                           <label style="display: block; position: relative">Email it to all subscribers <button style="position: absolute; left: -25px; margin: 0; top: -3px" type="button" class="btn btn-default tltp2" data-toggle="tooltip" data-placement="top" title="Send a password for selected lock/or group ID to all current subscribers (the ones from the subscribers list)"><i class="fa fa-question"></i></button></label>  
                           <button class="btn btn-success">Send Password</button>
                        </div>
                      </div>  

                	 </div>
                  
                </div>

                <div class="col-md-3 col-xs-12 email-msg">
                   <h4>Status</h4>
                   <p style="color: green"></p>
                   <div style="margin-top: 35px"><?php echo function_exists('proc_open') ? "<p style='color: #888'>Your PHP version supports email sending.</p>" : "<p style='color: indinared'>Sorry, emails can't be sent from current PHP version.</p>"; ?></div>
                </div>

              </div>
            </div>  
          </div>
        <?php else: ?>
          <div class="col-md-9 col-xs-12 sett">
            <h4>You need to setup up your email and smtp parameters before you can send emails.</h4>
            <p>Go to the <a href="settings.php">Settings</a> page from your dashboard and configure the neccessary information.</p>
        <?php endif; ?>
    </div>
    
    <?php include('inc/footer.php'); ?>
   <script>
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
   </script>

<?php else:  ?>
  <p style='color: indianred; background: rgb(254, 233, 233); border: 4px solid crimson; padding: 25px; max-width: 780px; display: block;margin:auto'>You are not authorized to be here.</p>
<?php endif; ?>