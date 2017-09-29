<?php

function download_ncbi_db($db){
  $message = "";

  if($db != ""){
    $message = $message .  "<p>Downloading and installing database from NCBI...";
    $out=[];
    $exit_code=-1;
    exec("sudo /usr/local/bin/admin_tools download_ncbi_db " . $db . " 2>&1", $out, $exit_code);
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

function delete_files($files) {
  if($files == ""){
    return "";
  }

  $deleted="";
  $failed="";
  foreach ($files as $file) {
    $out=[];
    $exit_code=-1;
    exec("sudo /usr/local/bin/admin_tools rmfile '/raw/" . $file . ".*' 2>&1", $out, $exit_code);
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
  $out = shell_exec('ls /raw/ | grep ".fa$"');
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
