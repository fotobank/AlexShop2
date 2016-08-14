<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ContentLock Dashboard</title>
    <!-- Bootstrap core CSS -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
     <!-- Main Login CSS -->
    <link href='../assets/css/admin.css' rel='stylesheet' type='text/css'>
     <!-- FONTAWESOME STYLES-->
    <link href="../assets/css/font-awesome.min.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="../assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>

<body>
    
    <div id="wrapper"  data-action="<?php echo dirname($_SERVER['HTTP_HOST']); ?>">
     <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div style="color: white; padding: 15px;float: right;font-size: 16px;"> <a style=" background: #2C7453;" href="../logout.php" class="btn btn-danger square-btn-adjust">Logout</a> </div>
      </nav>   
      <!-- /. NAV TOP  -->