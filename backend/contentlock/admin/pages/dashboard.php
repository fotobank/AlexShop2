<?php
session_start();
error_reporting(E_ALL);

if (isset($_SESSION['id'])):
    $name = $_SESSION['username'];
    //include database information
    // and pagination
    include('../inc/config.php');
    include('inc/pagination.php');
    $connect = @new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    $data = $stats = $subs = $sent = '';
    $tp = '';
    if (!$connect->connect_error){
        $pagenum = 1;
        $self = $_SERVER['PHP_SELF'];
        if (isset($_GET['pn'])){
            $pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
        }
        //get stats from database for ocks and subscribers
        // and total emails sent to subscribers
        $sett = $connect->query("SELECT 1 FROM `settings` LIMIT 1");
        $data = data('single', $pagenum);
        $group = data('group', $pagenum);
        $locks = $connect->query("SELECT id FROM locks");
        $stats = $connect->query("SELECT SUM(stats) FROM locks");
        $stats = mysqli_fetch_row($stats);
        $all = $connect->query("SELECT * FROM locks");
        $subs = $connect->query("SELECT id FROM subscribers");
        $sent = $connect->query("SELECT SUM(stats) FROM subscribers");
        $sent = mysqli_fetch_row($sent);
        // collect chart information
        $chart['labels'] = [];
        $chart['data'] = [];
        $dy = date("y") . '-' . date("m");
        $dt = 0;
        if (isset($_GET['dt'])){
            $dt = $_GET['dt'];
            $dy = date("y") . '-' . date("m", strtotime($dt . " months"));
        }
        $days = date("t", strtotime($dt . " months"));
        $from = date("y") . '-' . date("m", strtotime($dt . " months")) . '-' . '01';
        $to = date("y") . '-' . date("m", strtotime($dt . " months")) . '-' . date("t", strtotime($dt . " months"));
        $from = $connect->real_escape_string($from);
        $to = $connect->real_escape_string($to);
        $view = 'All';
        $chq = "SELECT * FROM `unlocks` WHERE DATE(`timestamp`) BETWEEN '$from' AND '$to'";
        if (isset($_GET['type']) && isset($_GET['id'])){
            $tp = $connect->real_escape_string($_GET['type']);
            $dd = $connect->real_escape_string($_GET['id']);
            $view = $dd;
            $chq = "SELECT * FROM `unlocks` WHERE `$tp` = '$dd' AND DATE(`timestamp`) BETWEEN '$from' AND '$to'";
        }
        $chs = $connect->query($chq);
        if ($data && $data->num_rows > 0) :
            $g = 0;
            while ($g < $days):
                $n = 0;
                $g++;
                $day = $dy . '-' . (string)$g;
                if ($g < 10) $day = $dy . '-0' . (string)$g;
                foreach ($chs as $row):
                    if (trim(substr($row['timestamp'], 2, 9)) === $day) $n++;
                endforeach;
                array_push($chart['labels'], $g);
                array_push($chart['data'], $n);
            endwhile;
        else:
            $g = 0;
            array_push($chart['data'], 0);
            while ($g < $days):
                $g++;
                array_push($chart['labels'], $g);
            endwhile;
        endif;
        if (isset($_GET['delete']) && isset($_GET['month'])){
            if ($_GET['month'] != 'Select month'){
                $mnth = $_GET['month'];
                $nmb = cal_days_in_month(CAL_GREGORIAN, $mnth, date('y'));
                $from = date("y") . '-' . $mnth . '-' . '01';
                $to = date("y") . '-' . $mnth . '-' . $nmb;
                $from = $connect->real_escape_string($from);
                $to = $connect->real_escape_string($to);
                $chq = "DELETE FROM `unlocks` WHERE DATE(`timestamp`) BETWEEN '$from' AND '$to'";
                $succ = $connect->query($chq);
            }
        }

    } else {
        echo 'Error connecting to database.';
    }

    ?>
    <?php include('inc/head.php'); ?>

    <?php include('inc/sidebar.php'); ?>

    <div id = "page-wrapper">
        <div id = "page-inner">
            <div class = "row">
              <div class = "col-md-12">
                <?php
                if (!$sett){
                    echo '<p style="background: rgb(237, 190, 190); border: 2px solid crimson; padding: 15px">You need to configure your email <a href="settings.php">settings</a> in order to send password in emails and in order to be able to automatically send emails after user subscribes</p>';
                }
                ?>
                  <h1 class = "page-header"><img class = "icn" src = "../assets/images/home.png" alt = "icon"/>Dashboard</h1>
    			       <h4><?php echo 'Welcome Back ' . $name; ?></h4>
              </div>
            </div>

             <div class = "row">
                <div class = "col-md-3 col-sm-6 col-xs-6">
                    <div class = "panel panel-back noti-box">
                        <span class = "icon-box bg-color-red set-icon">
                            <i class = "fa fa-expeditedssl"></i>
                        </span>
                        <div class = "text-box">
                            <p class = "main-text"><?php echo $locks ? $locks->num_rows : 0; ?> Locks</p>
                            <p class = "text-muted">Created</p>
                        </div>
                    </div>
                </div>
                <div class = "col-md-3 col-sm-6 col-xs-6">
                    <div class = "panel panel-back noti-box">
                        <span class = "icon-box bg-color-green set-icon">
                            <i class = "fa fa-unlock"></i>
                        </span>
                        <div class = "text-box">
                            <p class = "main-text"><?php echo $stats[0] ? $stats[0] : 0; ?> Unlocks</p>
                            <p class = "text-muted">Times Unlocked</p>
                        </div>
                     </div>
                </div>
                <div class = "col-md-3 col-sm-6 col-xs-6">
                  <div class = "panel panel-back noti-box">
                      <span class = "icon-box bg-color-blue set-icon">
                          <i class = "fa fa-users"></i>
                      </span>
                      <div class = "text-box">
                          <p class = "main-text"><?php echo $subs ? $subs->num_rows : 0; ?> Subscribers</p>
                          <p class = "text-muted">Leads Collected</p>
                      </div>
                   </div>
               </div>
                <div class = "col-md-3 col-sm-6 col-xs-6">
                   <div class = "panel panel-back noti-box">
                      <span class = "icon-box bg-color-brown set-icon">
                          <i class = "fa fa-envelope"></i>
                      </span>
                      <div class = "text-box">
                          <p class = "main-text"><?php echo $sent[0] ? $sent[0] : 0; ?> Emails</p>
                          <p class = "text-muted">Passwords Sent To Subscribers</p>
                      </div>
                   </div>
                </div>
              </div>
            <!-- /. ROW  -->

             <div class = "row">
                <div class = "col-md-12 col-sm-12 col-xs-12">
                  <div class = "panel panel-default">
                    <div class = "panel-heading">
              	      <h2 class = "sub-header">Single Lock</h2>
                     </div>  
                     <div class = "panel-body">
                       <div class = "table-responsive">
                          <table class = "table table-striped table-bordered table-hover">
                            <thead>
                              <tr>
                                <th>Lock-ID</th>
                                <th>Password</th>
                                <th>Statistics <button type = "button" class = "btn btn-default tltp"
                                                       data-toggle = "tooltip" data-placement = "top"
                                                       title = "Total number of times this specific lock has been unlocked."><i
                                            class = "fa fa-question"></i></button></th>
                              </tr>
                            </thead>
                            <tbody>
                          <?php
                          $exs = false;
                          if ($data->num_rows > 0) :
                              foreach ($data as $row):
                                  if ($row['group'] === 'none'):
                                      $exs = true;
                                      ?>
                                      </tr>
                                      <td><?php echo $row['lock_id']; ?></td>
                                      <td><?php echo $row['password']; ?></td>
                                      <td><?php echo $row['stats']; ?></td>
                                      </tr>

                                  <?php endif; endforeach; endif; ?>
                          <?php if (!$exs): ?>
                              <tr>
                       	 		<td colspan = "3">You have not created any single locks yet</td>
                       	 	</tr>
                          <?php endif; ?>
                            </tbody>
                          </table>
                          <div><?php echo pagination($pagenum); ?></div>
                        </div>
                      </div>
                    </div>
                 </div>
              </div>        

              <div class = "row">
                <div class = "col-md-12 col-sm-12 col-xs-12">
                  <div class = "panel panel-default">
                    <div class = "panel-heading">
                  	    <h2 class = "sub-header">Groups Lock</h2>
                    </div>
                    <div class = "panel-body">
                       <div class = "table-responsive">
                          <table class = "table table-striped table-bordered table-hover">
                            <thead>
                              <tr>
                                <th>Group Lock-ID</th>
                                <th>Password</th>
                                <th>Statistics <button type = "button" class = "btn btn-default tltp"
                                                       data-toggle = "tooltip" data-placement = "top"
                                                       title = "Total number of times this specific lock has been unlocked."><i
                                            class = "fa fa-question"></i></button></th>
                              </tr>
                            </thead>
                            <tbody>
                          <?php
                          $exists = false;
                          if ($group->num_rows > 0) :
                              foreach ($group as $row):
                                  if ($row['group'] != 'none'):
                                      $exists = true;
                                      ?>
                                      </tr>
                                      <td><?php echo $row['group']; ?></td>
                                      <td><?php echo $row['password']; ?></td>
                                      <td><?php echo $row['stats']; ?></td>
                                      </tr>

                                  <?php endif; endforeach; endif; ?>
                          <?php if (!$exists): ?>
                              <tr>
                       	 		<td colspan = "3">You have not created any group locks yet</td>
                       	 	</tr>
                          <?php endif; ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                 </div>
              </div>  
              <div id = "dash" class = "row">
                  <h4 style = "border-bottom: 1px solid #ddd; padding: 0 0 12px 15px">
                  <i class = "fa fa-area-chart "></i> Unlocks - Monthly Statistic
                      <button type = "button" class = "btn btn-default tltp2" data-toggle = "tooltip"
                              data-placement = "top" title = "Graphical Representation of your monthly statistics. In the chart below you can see total number of unlocks for each day of the selected month. You can also preview stats for every lock item, by selecting it from the select box in the right corner below."><i
                              class = "fa fa-question"></i></button>
                  </h4>
                  <div id = "dates-nav" class = "col-xs-12 col-md-3">
                     <a id = "prv" href = "<?php echo $self . '?dt=' . ($dt - 1) . '#dates-nav'; ?>"><i
                             class = "fa fa-caret-left"></i></a>
                      <?php echo date("F", strtotime($dt . ' months')); ?>
                      <a id = "nxt" href = "<?php echo $self . '?dt=' . ($dt + 1) . '#dates-nav'; ?>"><i
                              class = "fa fa-caret-right"></i></a>
                  </div>
                  <div class = "col-xs-12 col-md-6">
                     <h4 id = "bzv" data-tp = "<?php if ($tp === 'lock_id'){
                         echo '.lock_id';
                     } elseif ($tp === 'group') {
                         echo '.group';
                     } ?>">Currently Viewing: <span><?php echo $view; ?><span></h4>
                  </div>
                  <div class = "fls col-xs-12 col-md-3">
                      <select class = "tzb">
                        <option>Select type...</option>
                        <option data-id = "id">Lock-ID</option>
                        <option data-id = "group">Group</option>
                        <option value = "all" data-id = "<?php echo $self . '#dates-nav'; ?>">All</option>
                      </select>
                      <select class = "id">
                        <option>Select ID</option>
                          <?php
                          if ($all->num_rows > 0) :
                              foreach ($all as $row):
                                  if ($row['group'] === 'none'): ?>
                                      <option
                                          data-id = "<?php echo $self . '?dt=' . $dt . '&type=lock_id&id=' . $row['lock_id'] . '#dates-nav'; ?>"
                                          data-add = "<?php echo '&type=lock_id&id=' . $row['lock_id'] . '#dates-nav'; ?>"
                                          value = "<?php echo $row['lock_id']; ?>"><?php echo $row['lock_id']; ?></option>
                                  <?php endif; endforeach; endif; ?>
                       </select>  
                       <select class = "group">
                        <option>Select ID</option>
                           <?php
                           if ($all->num_rows > 0) :
                               foreach ($all as $row):
                                   if ($row['group'] != 'none'): ?>
                                       <option
                                           data-id = "<?php echo $self . '?dt=' . $dt . '&type=group&id=' . $row['group'] . '#dates-nav'; ?>"
                                           data-add = "<?php echo '&type=group&id=' . $row['group'] . '#dates-nav'; ?>"
                                           value = "<?php echo $row['group']; ?>"><?php echo $row['group']; ?></option>
                                   <?php endif; endforeach; endif; ?>
                        </select>   
                    </div>       
                    <canvas id = "substats" width = "900" height = "560"></canvas>
              </div>
              <div>
                <h4>
                  Delete Records for:
                  <select data-href = "<?php echo $self; ?>">
                    <option>Select month</option>
                    <option value = "01">January</option>
                    <option value = "02">February</option>
                    <option value = "03">March</option>
                    <option value = "04">April</option>
                    <option value = "05">May</option>
                    <option value = "06">Jun</option>
                    <option value = "07">July</option>
                    <option value = "08">August</option>
                    <option value = "09">September</option>
                    <option value = "10">October</option>
                    <option value = "11">November</option>
                    <option value = "12">December</option>
                  </select>
                  <button class = "btn btn-danger" id = "delete">Delete</button>
                  <button type = "button" class = "btn btn-default tltp2" data-toggle = "tooltip" data-placement = "top"
                          title = "You can delete old records from the statistics. This will not delete your total statistic that is showed next to every lock in the tables above, only old records that are generated into chart. It is advised to clean old records every 3-4 months for removing unnecessary data from database."><i
                          class = "fa fa-question"></i></button>
                </h4>  
              </div>
          </div>
       </div>
    </div>


    <script type = "text/javascript" src = "../assets/js/chart.js"></script>
    <script type = "text/javascript" src = "../assets/js/chart-line.js"></script>
    <script type = "text/javascript">
      var ctx = document.getElementById("substats").getContext("2d");
      var data = {
          labels: [<?php $m = 1; foreach ($chart['labels'] as $label){
              $n = count($chart['labels']);
              if ($n != $m){
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
                  data: [<?php $m = 1; foreach ($chart['data'] as $d){
                      $n = count($chart['labels']);
                      if ($n != $m){
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

<?php else: ?>
    <p style = 'color: indianred; background: rgb(254, 233, 233); border: 4px solid crimson; padding: 25px; max-width: 780px; display: block;margin:auto'>You are not authorized to be here.</p>
<?php endif; ?>