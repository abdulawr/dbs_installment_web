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

$expireAfter = 30;
if(isset($_SESSION['last_action'])){
  $secondsInactive = time() - $_SESSION['last_action'];
  $expireAfterSeconds = $expireAfter * 60;
  if($secondsInactive >= $expireAfterSeconds){
      session_unset();
      session_destroy();
      ?>
      <script>
        location.href="index?expire=expire";
      </script>
     <?php
  }
  
}

$_SESSION['last_action'] = time();

if(isset($_GET["cmp"]) && !empty($_GET["cmp"])){
   $cmp = DBHelper::escape($_GET["cmp"]);
   $company = DBHelper::get("SELECT * FROM `company_info` where id = '$cmp'")->fetch_assoc();
   $_SESSION['company'] = $company;
   $_SESSION['company_id'] = $company['id'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $_SESSION["company"]["name"];?></title>
  <link rel="shortcut icon" type="image/jpg" href="c_images/<?php echo $_SESSION['company']['logo'];?>"/>
  
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

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


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

  .titleBackground{
    background: #0F2027;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #2C5364, #203A43, #0F2027);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #2C5364, #203A43, #0F2027); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    color:white;
  }

  </style>
 
</head>