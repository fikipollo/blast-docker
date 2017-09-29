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
        $message="";

        if (isset($_POST['action'])){
          $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

          switch ($_POST['action']) {
            case 'download':
            $message = download_ncbi_db($_POST['db']);
            break;
            case 'delete_files':
            $message = delete_files($_POST['delete_files']);
            break;
            case 'delete_databases':
            $message = delete_databases($_POST['delete_databases']);
            break;
          }
          unset($_POST);
        }
        echo $message;
        ?>
        <a href="admin.php" class='btn btn-default'>Back to Admin site</a>
      </div>
    </div>
  </div>
</body>
</html>
