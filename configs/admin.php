<!DOCTYPE html>
<html>
<head>
  <title>BLAST admin site</title>
  <!--ONLINE REQUIREMENTS-->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" type='text/css'>
  <link href="https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css" rel="stylesheet" type='text/css'>
  <!--ONLINE REQUIREMENTS-->
  <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script type="text/javascript">
  function closeSession(){
    var dest = document.location.href.replace("//","//log:out@");
    var xhr = new XMLHttpRequest();
    xhr.open("POST", dest, true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send();
    location.reload();
  }
  </script>
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
    <div class='col-sm-6'>
      <form action="upload_file.php" method="post" class="box"  style='margin-bottom:20px;'>
        <h2>Upload FASTA file</h2>
        <p class='text-info'>Upload a fasta file for creating a BLAST database.</p>
        <input type="hidden" name="action" value="create_user">
        <div class="form-group">
          <label for="uploaded_file">Fasta file:</label>
          <input type="file" class="form-control" id="uploaded_file" name="uploaded_file">
        </div>
        <button type="submit" class="btn btn-success">Upload file</button>
        <p class='well well-sm text-info' style="margin-top:10px;">
          <i class='fa fa-info-circle'></i><b> About file uploading</b><br>
          The max size for uploaded is currently <b>XXXX MB</b>.<br>
          Bigger files can be uploaded via FTP or directy placed in the corresponding folder.
        </p>
      </form>
      <form action="download_ncbi_db.php" method="post" class="box">
        <h2>Download NCBI databases</h2>
        <p class='text-info'>
          NCBI provides publicly available sequences as pre-formatted BLAST databases.<br>
          Note that some databases are huge and downloading can take several minutes.
        </p>
        <table class="table table-striped" style="display: block; margin: auto; width: 250px; ">
          <thead><tr><th style=" width: 200px; ">Database name</th><th></th></tr></thead>
          <tbody>
            <?php
            $databases = getNCBIDatabases();
            foreach ($databases as $database) {
              if($database != ""){
                echo "<tr><td>" . $database . "</td><td><a href='download_ncbi_db.php?db=" . $database . "'><i class='fa fa-download' aria-hidden='true'></i></a></td></tr>";
              }
            }
            ?>
          </tbody>
        </table>
      </form>
    </div>
    <div class='col-sm-6 box' style='margin-bottom:20px;'>
      <h2>Available FASTA files</h2>
      <p class='text-info'>These are the FASTA files contained in data directory.</p>
      <form action="action_finished.php" method="post">
        <input type="hidden" name="action" value="delete_files">
        <button type="submit" class="btn btn-danger">Delete selected files</button>
        <table class="table table-striped">
          <thead>
            <tr><th style=" width: 30px;"></th><th>File name</th></tr>
          </thead>
          <tbody>
            <?php
            $files = getFiles();
            foreach ($files as $file) {
              if($file != ""){
                echo "<tr><td><input type='checkbox' name='delete_files[]' value='" . $file . "'></td><td>" . $file . "</td></tr>";
              }
            }
            ?>
          </tbody>
        </table>
      </form>
    </div>
    <div class='col-sm-6 box' style='margin-bottom:20px;'>
      <h2>Installed databases</h2>
      <p class='text-info'>These are the installed databases in BLAST.</p>
      <form action="action_finished.php" method="post">
        <input type="hidden" name="action" value="delete_databases">
        <button type="submit" class="btn btn-danger">Delete selected databases</button>
        <table class="table table-striped">
          <thead>
            <tr><th style=" width: 30px;"></th><th>Database name</th></tr>
          </thead>
          <tbody>
            <?php
            $databases = getDatabases();
            foreach ($databases as $database) {
              if($database != ""){
                echo "<tr><td><input type='checkbox' name='delete_databases[]' value='" . $database . "'></td><td>" . $database . "</td></tr>";
              }
            }
            ?>
          </tbody>
        </table>
      </form>
    </div>
  </div>
</body>
</html>
