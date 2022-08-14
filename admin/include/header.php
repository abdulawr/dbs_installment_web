<?php
session_start();
if(!isset($_SESSION["isAdmin"]) && !isset($_SESSION["type"])){
  ?>
  <script>
    location.href="index?error=Direct access is not allowed!";
  </script>
 <?php
}
include("../include/conn.php");
include("../include/DBHelper.php");
include("../include/Encryption.php");
include("../include/HelperFunction.php");
include("include/response.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DBS INSTALMENT</title>
  <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
  
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

  <style>

@font-face {
        font-family: urdu_fon;
        src: url(font/urdu.ttf);
        }
  
  .urdu{
    font-family: urdu_fon;
    direction: rtl;
    text-align: right;
  }

  </style>
 
</head>