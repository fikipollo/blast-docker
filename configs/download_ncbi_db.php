<!DOCTYPE html>
<html>
<head>
  <title>BLAST admin site</title>
  <!--ONLINE REQUIREMENTS-->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" type='text/css'>
  <link href="https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css" rel="stylesheet" type='text/css'>
  <!--ONLINE REQUIREMENTS-->
  <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <style>
  body {max-width: 1024px; margin: auto;background-color:#333;}
  .box{border: 5px solid #eee; padding: 10px; border-radius: 10px;}
  </style>
</head>

<body>
  <?php
  include 'admin_tools.php';

  if (!validAdminSession()){
    echo "<a class='btn btn-danger pull-right' onclick='javascript:closeSession()'> <i class='fa fa-sign-out' aria-hidden='true'></i> Logout</a>";
    echo "<h1 style='color:#fff;'>Not allowed</h1>";
    exit;
  }
  ?>
  <a class='btn btn-danger pull-right' onclick='javascript:closeSession()'> <i class='fa fa-sign-out' aria-hidden='true'></i> Logout</a>
  <h1 style='color:#fff;'>Welcome to BLAST admin site</h1>
  <div style="background-color:#fff;padding: 80px 60px;" class="row">
    <div class='col-sm-12' style='margin-bottom:10px;'>
      <div class='well well-bg'>
        <?php
        if (isset($_GET['db'])) {
          echo "<h3>Download NCBI database</h3>";
          echo "<p><b>Target database: </b>". $_GET["db"] . "</p>";
          echo "<p class='text-info'>Click in the following button to start the download process.<br>Note that this process can take several minutes. <b>Do not reload or close this window</b> until the process ends.</p>";
          echo "<form action='action_finished.php' method='post' >";
          echo "  <input type='hidden' name='action' value='download'>";
          echo "  <input type='hidden' name='db' value='". $_GET["db"] . "'>";
          echo "  <button type='submit' class='btn btn-success'><i class='fa fa-download' aria-hidden='true'></i> Download database</button>";
          echo "  <a href='admin.php' class='text-danger'> or Cancel and go back to Admin site</a>";
          echo "</form>";
        }else{
          echo "<p class='text-danger'>Database not found, unable to download.</p>";
          echo "<a href='admin.php' class='text-danger'> Go back to Admin site</a>";
        }
        ?>
      </div>
    </div>
  </div>
</body>
</html>
