<?php
     include( '../inc/config.php' ); 
     $connect = @new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
     $sql = "SELECT * FROM locks";
     $rows = $connect->query($sql);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="noindex,nofollow" />
    <title>Not Found</title>
    <script>
      setTimeout(function(){
          document.getElementById('keys').remove();
      },450)
    </script>
</head>

<body>

  <h3>Ooops!</h3>
  <h4>Sorry That page do not exists. Try something different</h4>
  <div id="keys" style="display: none">
     <?php 
        foreach( $rows as $row ): 
        if( $row['group'] === 'none' ) {
          $id = 'lock_id';
        } else {
          $id = 'group';
        }
     ?>
     <span class="key"><?php echo $row[$id] . ':' . $row['password']; ?></span>
     <?php endforeach; ?>
  </div>

<?php $connect->close(); ?>
</body>

</html>