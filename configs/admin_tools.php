<?php

function upload_file(){
  $message = "";

  if($_FILES != ""){
    $message = $message .  "<p>Uploading new file...";

    $target_dir = "/tmp/";

    $target_file = $target_dir . basename($_FILES["uploaded_file"]["name"]);
    $extension = pathinfo($target_file,PATHINFO_EXTENSION);
    $max_file_size = shell_exec("sudo /usr/local/bin/admin_tools get_max_file_size");

    $error_message="";

    // Check if image file is a actual image or fake image
    if($_FILES["uploaded_file"]["size"] > $max_file_size*1000000) {
      $error_message = "Sorry, your file is too large. Use FTP uploading instead.";
    }elseif($extension != "fa" && $extension != "fasta") {
      $error_message = "Sorry, only FASTA files are allowed (.fa and .fasta extensions).";
    }elseif (!move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], $target_file)) {
      $error_message = "Sorry, there was an error uploading your file.";
    }else{
      shell_exec("sudo /usr/local/bin/admin_tools move_file " . $target_file);
    }

    if($error_message != ""){
      $message = $message .  "<span class='text-success'>Failed.</span></p>";
      $message = $message .  "<b>Error log</b>";
      $message = $message .  "<pre>";
      $message = $message .  $error_message;
      $message = $message .  "</pre>";
    }else{
      $message = $message .  "<span class='text-success'>Done.</span></p>";
    }
  }else{
    $message = $message .  "<p class='text-danger'>File not found, unable to upload.</p>";
  }
  return $message;
}

function download_ncbi_db($db, $name){
  $message = "";

  if($db != ""){
    $message = $message .  "<p>Downloading and installing database from NCBI...";
    $out=[];
    $exit_code=-1;
    exec("sudo /usr/local/bin/admin_tools download_ncbi_db " . $db . " " . $name . " 2>&1", $out, $exit_code);
    if($exit_code == 0){
      $message = $message .  "<span class='text-success'>Done.</span></p>";
    }else{
      $message = $message .  "<span class='text-success'>Failed (Exit code" . $exit_code . ").</span></p>";
      $message = $message .  "<b>Error log</b>";
      $message = $message .  "<pre>";
      foreach ($out as $line) {
        $message = $message .  $line;
      }
      $message = $message .  "</pre>";
    }
  }else{
    $message = $message .  "<p class='text-danger'>Database not found, unable to download.</p>";
  }
  return $message;
}

function install_db($file, $name){
  $message = "";

  if($file != ""){
    $message = $message .  "<p>Checking if valid file...";
    if(preg_match('/(\.fa|\.fasta)$/i', $file)){
      $message = $message .  "<span class='text-success'>Valid.</span></p>";
    }else{
      $message = $message .  "<span class='text-danger'>File not valid. Check if file is a valid FASTA file.</span></p>";
      return $message;
    }

    $message = $message .  "<p>Creating database...";
    $out=[];
    $exit_code=-1;
    exec("sudo /usr/local/bin/admin_tools build_database " . $file . " " . $name . " 2>&1", $out, $exit_code);
    if($exit_code == 0){
      $message = $message .  "<span class='text-success'>Done.</span></p>";
    }else{
      $message = $message .  "<span class='text-danger'>Failed (Exit code" . $exit_code . ").</span></p>";
      $message = $message .  "<b>Error log</b>";
      $message = $message .  "<pre>";
      foreach ($out as $line) {
        $message = $message .  $line;
      }
      $message = $message .  "</pre>";
    }
  }else{
    $message = $message .  "<p class='text-danger'>File not found, unable to install.</p>";
  }
  return $message;
}


function delete_files($files) {
  if($files == ""){
    return "";
  }

  $deleted="";
  $failed="";
  foreach ($files as $file) {
    $out=[];
    $exit_code=-1;
    exec("sudo /usr/local/bin/admin_tools rmfile '/raw/" . $file . "' 2>&1", $out, $exit_code);
    if($exit_code == 0){
      $deleted = $deleted . " " . $file;
    }else{
      $failed = $failed . " " . $file;
    }
  }
  $message = "";
  if($deleted != ""){
    $message="<p class='text-success'>The following files have been successfully removed: " . $deleted . ".</p>";
  }

  if($failed != ""){
    $message = $message . "<p class='text-danger'>The following files were not removed: " . $failed . ".</p>";
    $message = $message . "<b>Error log</b>";
    $message = $message . "<pre>";
    foreach ($out as $line) {
      $message = $message . $line;
    }
    $message = $message . "</pre>";
  }
  return $message;
}

function delete_databases($files) {
  if($files == ""){
    return "";
  }

  $deleted="";
  $failed="";
  foreach ($files as $file) {
    $out=[];
    $exit_code=-1;
    exec("sudo /usr/local/bin/admin_tools rmfile '/db/" . $file . ".*' 2>&1", $out, $exit_code);
    if($exit_code == 0){
      $deleted = $deleted . " " . $file;
    }else{
      $failed = $failed . " " . $file;
    }
  }
  $message = "";
  if($deleted != ""){
    $message="<p class='text-success'>The following databases have been successfully removed: " . $deleted . ".</p>";
  }

  if($failed != ""){
    $message = $message . "<p class='text-danger'>The following databases were not removed: " . $failed . "</p>";
    $message = $message . "<b>Error log</b>";
    $message = $message . "<pre>";
    foreach ($out as $line) {
      $message = $message . $line;
    }
    $message = $message . "</pre>";
  }
  return $message;
}

function getFiles() {
  $out = shell_exec('ls /raw/');
  return explode("\n", rtrim($out, "\n"));
}

function getDatabases() {
  $out = shell_exec('ls /db/ | sed s:\.[^./]*$:: | sort -u');
  return explode("\n", rtrim($out, "\n"));
}

function getNCBIDatabases() {
  $out = shell_exec('ncbi-blast-dbs');
  return explode(", ", rtrim($out, "\n"));
}

function validAdminSession(){
  return true;
}
?>
