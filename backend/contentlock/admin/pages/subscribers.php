<?php
session_start();
error_reporting(E_ALL);

if (isset($_SESSION['id'])):
	$name = $_SESSION['username'];
  include( 'inc/pagination.php' );
  $pagenum = 1;
  if(isset($_GET['pn'])){
    $pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
  }
  $data = data('subs', $pagenum);
  $chart['labels'] = array();
  $chart['data'] = array();
  $dy = date("y") . '-'. date("m"); 
  $dt = 0;
  if( isset($_GET['dt']) ) {
     $dt = $_GET['dt'];
     $dy = date("y") . '-'. date( "m", strtotime($dt ." months") );
  }
  $days = date( "t", strtotime($dt ." months") );
  if ( $data && $data->num_rows > 0 ) :
     $g = 0;
     while( $g < $days ):
        $n = 0;
        $g++;
        $day  = $dy.'-'. (string)$g;
        if( $g < 10 ) $day  = $dy . '-0'. (string)$g; 
        foreach($data as $row):                      
           if( trim(substr($row['timestamp'], 2, 9)) === $day ) $n++;
        endforeach; 
        array_push($chart['labels'], $g);
        array_push($chart['data'], $n);
     endwhile;
  else:
     $g = 0;
     array_push($chart['data'], 0);
     while( $g < $days ):
        $g++;
        array_push($chart['labels'], $g);
     endwhile;
  endif;
?>
  <?php include('inc/head.php'); ?>

  <?php include('inc/sidebar.php'); ?>

  <div id="page-wrapper" >
      <div id="page-inner">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="page-header"><img class="icn" src="../assets/images/subsc.png" alt="icon" />Subscribers</h1>
              </div>
          </div>

          <div class="row" >
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="panel panel-default">
                <div class="panel-heading">
      	           <h2 class="sub-header">Subscribers List  <a id="subdown"><i class="fa fa-download"></i> Download</a><a href="../inc/subscribers.txt"></a></h2>
                </div>   
                <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Email</th>
                              <th>Refferer <button type="button" class="btn btn-default tltp" data-toggle="tooltip" data-placement="top" title="The lock or group ID which lured (reffered) this user to subscribe in order to unlock it."><i class="fa fa-question"></i></button></th>
                              <th>Statistics <button type="button" class="btn btn-default tltp" data-toggle="tooltip" data-placement="top" title="Total number of emails sent to this subscriber, either from autoresponder form, or by sending it from <send password> section."><i class="fa fa-question"></i></button></th>
                              <th>Remove <button type="button" class="btn btn-default tltp" data-toggle="tooltip" data-placement="top" title="Delete subscriber from the database."><i class="fa fa-question"></i></button></th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php 
                          	if ( $data && $data->num_rows > 0 ) :
                          	 foreach($data as $row):
                           ?>
                         	   <tr>
            	                  <td><?php echo $row['email']; ?></td>
            	                  <td><?php echo $row['refferer']; ?></td>
            	                  <td><?php echo $row['stats']; ?></td>
                                <td><b class="uns" data-id="<?php echo $row['id']; ?>" title="Delete Subscriber from database">X</b></td>
                              </tr>
                           
                         	 <?php endforeach; else: ?>
                         	 	<tr>
                         	 		<td colspan="3">You do not have any subscribers yet</td>
                         	 	</tr>	
                         	 <?php endif; ?>
                          </tbody>
                      </table>
                      <div><?php echo pagination($pagenum); ?></div>
                    </div>
                  </div>
                </div>
                <div>
                  <h4 style="border-bottom: 1px solid #ddd; padding: 0 0 12px 15px"><i class="fa fa-area-chart "></i> Subscribers - Monthly Statistic</h4>
                  <div id="dates-nav">
                     <a href="<?php echo $_SERVER['PHP_SELF'].'?dt='. ($dt-1) . '#dates-nav'; ?>"><i class="fa fa-caret-left"></i></a> 
                     <?php echo date("F", strtotime($dt." months")); ?> 
                     <a href="<?php echo $_SERVER['PHP_SELF'].'?dt='. ($dt+1) . '#dates-nav'; ?>"><i class="fa fa-caret-right"></i></a>
                  </div>
                  <canvas id="substats" width="900" height="560"></canvas>
                </div>
              </div>
          </div>
      </div> 
   </div>    

   <script type="text/javascript" src="../assets/js/chart.js"></script>
   <script type="text/javascript" src="../assets/js/chart-line.js"></script>
   <script type="text/javascript">
      var ctx = document.getElementById("substats").getContext("2d");
      var data = {
          labels: [<?php $m = 1; foreach( $chart['labels'] as $label ) {
            $n = count($chart['labels']);
            if( $n != $m ) {
              echo $label . ',';
            } else {
              echo $label;
            }
            $m++;
          } ?>],
          datasets: [
              {
                  label: "Subscribers",
                  fillColor: "rgba(220,220,220,0.2)",
                  strokeColor: "rgba(220,220,220,1)",
                  pointColor: "lightblue",
                  pointStrokeColor: "#fff",
                  pointHighlightFill: "#fff",
                  pointHighlightStroke: "rgba(220,220,220,1)",
                  data: [<?php $m = 1; foreach( $chart['data'] as $d ) {
                    $n = count($chart['labels']);
                    if( $n != $m ) {
                      echo $d . ',';
                    } else {
                      echo $d;
                    }
                    $m++;
                  } ?>]
              }
          ]
      };
      var stats = new Chart(ctx).Line(data);
    </script>
   <?php include('inc/footer.php'); ?>
   <script>
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
   </script>

<?php else:  ?>
  <p style='color: indianred; background: rgb(254, 233, 233); border: 4px solid crimson; padding: 25px; max-width: 780px; display: block;margin:auto'>You are not authorized to be here.</p>
<?php endif; ?>