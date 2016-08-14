<?php 
 include( '../inc/config.php' ); 
 // database information
 define( 'DB_NAME', $DB_NAME );
 define( 'DB_HOST', $DB_HOST );
 define( 'DB_USER', $DB_USER );
 define( 'DB_PASS', $DB_PASS );

function pagination($pagenum) {
    $connect = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (  !$connect->connect_error ) {
        $sql = "SELECT id FROM subscribers";
        $data = $connect->query($sql);
        //pagination adapted from - https://goo.gl/bYdRss
        $rows = $data->num_rows;
        $paged = 10;
        $last = ceil($rows/$paged); 
        if($last < 1){
          $last = 1;
        }
        if ($pagenum < 1) { 
            $pagenum = 1; 
        } else if ($pagenum > $last) { 
            $pagenum = $last; 
        }

        $paginationCtrls = '';
        if($last != 1){
          if ($pagenum > 1) {
                $previous = $pagenum - 1;
            $paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$previous.'">Previous</a> &nbsp; &nbsp; ';
            for($i = $pagenum-4; $i < $pagenum; $i++){
              if($i > 0){
                    $paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp; ';
              }
            }
          }
          $paginationCtrls .= ''.$pagenum.' &nbsp; ';
          for($i = $pagenum+1; $i <= $last; $i++){
            $paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp; ';
            if($i >= $pagenum+4){
              break;
            }
          }
            if ($pagenum != $last) {
                $next = $pagenum + 1;
                $paginationCtrls .= ' &nbsp; &nbsp; <a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'">Next</a> ';
            }
        }
    }
    $connect->close();
    return $paginationCtrls;
}

function data($type, $pagenum, $paged = 10) {
    $connect = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $data = '';
    $limit = 'LIMIT ' .($pagenum - 1) * $paged .',' .$paged;
    switch( $type ) {
        case 'subs':
        $sql = "SELECT * FROM subscribers ORDER BY id DESC $limit";
        break;
        case 'single':
        $sql = "SELECT * FROM `locks` WHERE `group` = 'none' ORDER BY id DESC $limit";
        break;
        case 'group':
        $sql = "SELECT * FROM `locks` WHERE `group` != 'none' ORDER BY id DESC $limit";
        break;
    }
    
    $data = $connect->query($sql);
    $connect->close();

    return $data;
}
?>