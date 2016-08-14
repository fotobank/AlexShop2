<?php
session_start();
error_reporting(E_ALL);

if (isset($_SESSION['id'])):
	include( '../inc/config.php' ); 
 	$connect = @new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
  $settings = false;
  $row = array();
 	if ( !mysqli_connect_errno() ) {
    $sql = "SELECT * FROM settings";
    $settings = $connect->query($sql);
    $connect->close(); 
    if( $settings ){
      foreach( $settings as $set ) {
        $row['smtp'] = $set['smtp'];
        $row['mail'] = $set['mail'];
        $row['password'] = $set['password'];
        $row['port'] = $set['port'];
        $row['sname'] = $set['sname'];
        $row['template'] = $set['template'];
      }
    }
 	} else {
 		echo 'Error connecting to database.';
 	}
?>
<?php include('inc/head.php'); ?>

  <?php include('inc/sidebar.php'); ?>

  <div id="page-wrapper" >
      <div id="page-inner">

          <div class="row" >
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="panel panel-default">
                <div class="panel-heading">
                   <h1><img class="icn" src="../assets/images/settings.png" alt="icon" />Settings</h1>
                </div>
              </div>     
              <div class="row">
                  <div class="col-md-12 col-xs-12 sett">
                    <table>
                    <tr>
                       <th>Site Name</th> 
                       <td><input type="text" id="sname" value="<?php echo ( $settings && $row['sname'] ) ? $row['sname'] : ''; ?>" /> <button style="left: 420px; top: -1px" type="button" class="btn btn-default tltp" data-toggle="tooltip" data-placement="top" title="Enter your site name, or any other Title you want to use as a subject in the email header."><i class="fa fa-question"></i></button></td>
                    </tr>
                    </table>
                    <hr/>
                  </div>
                  <div class="col-md-7 col-xs-12 sett">
                      <h4>Email Settings.</h4>
                      <table>
                        <tr>
                           <th>Admin Email</th> 
                           <td><input type="text" id="email" value="<?php echo ( $settings && $row['mail'] ) ? $row['mail'] : ''; ?>" /></td>
                        </tr>
                        <tr class="divider"></tr>
                        <tr>
                           <th>Email Password</th> 
                           <td><input type="text" id="pasw" value="<?php echo ($settings && $row['password']) ? $row['password'] : ''; ?>" /></td>
                        </tr>
                        <tr class="divider"></tr>
                        <tr>
                           <th>smtp</th> 
                           <td><input type="text" placeholder="Usualy smtp.gmail.com" id="smtp" value="<?php echo ($settings && $row['smtp']) ? $row['smtp'] : ''; ?>" /></td>
                        </tr>
                        <tr class="divider"></tr>
                        <tr>
                           <th>port</th> 
                           <td><input type="number" placeholder="Usualy 465" id="port" value="<?php echo ($settings && $row['port']) ? $row['port'] : ''; ?>" /></td>
                        </tr>
                        <tfoot>
                          <tr class="divider"></tr>
                           <tr>
                              <td colspan="3">You can read <a href="https://www.digitalocean.com/community/tutorials/how-to-use-google-s-smtp-server" target="_BLANK">this article</a> on more information how to set up gmail parameters.</td>
                           </tr>
                        </tfoot>
                      </table>
                  </div>
                  <div class="col-md-5 col-xs-12 templ">
                      <h4>Email Template <button style="top: 15px" type="button" class="btn btn-default tltp" data-toggle="tooltip" data-placement="left" title="Add content to the body text message, or create whole email template. You can use HTML and inline CSS to create any email template you want. You must include {$password} somewhere in the body where you want password to be generated."><i class="fa fa-question"></i></button></h4>
                      <span class="desc">Add text you want to appear in the message body of the email you send from ''send password'' section. <br/>
                      NOTE: You must Include <strong>{$password}</strong> form where you want current password to appear.</span>
                      <textarea style="margin-top: 10px"><?php if( $row && $row['template'] ) {echo $row['template'];} else { echo 'Password: <span style="color: darkblue; font-weight: bold">{$password}</span>'; } ?></textarea>
                      </div>

                      <div id="result" class="col-md-7 col-xs-12">
                        
                  </div>
                  <div class="col-md-12 col-xs-12">
                     <h4>Change Password.</h4>
                     <table>
                       <tr>
                         <th>New Password</th>
                         <td><input type="password" id="psc" /></td>
                       </tr>
                       <tr class="divider"></tr>
                       <tr>
                         <th>Repeat Password</th>
                         <td><input type="password" id="psc2" /></td>
                       </tr>
                     </table>
                  </div>
                  <div class="col-md-12 col-xs-12 sett">
                       <button class="btn btn-success sts" style="margin-top: 20px">Save Changes</button>
                      <div>
                        <p></p>
                      </div>
                  </div>
              </div>
            </div>
          </div>
      </div>
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