<?php

  $dburl = "param";
  $dbname = "param";
  $dbpassword = "param";
  $dbuser = "param";

  $link = mysqli_connect($dburl, $dbname, $dbpassword, $dbuser);

  if (mysqli_connect_error()) {
    die("There was an error connecting to the database.");
  }

  session_start();

  ob_start();
  
?>