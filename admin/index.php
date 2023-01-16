<?php
session_start();
if(isset($_SESSION["isAdmin"]) && isset($_SESSION["type"])){
  ?>
  <script>
    location.href="dashboard";
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
  <script src="plugins/jquery/jquery.min.js"></script>
  <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
   <!--Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
   <!--Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
   <!--icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
   <!--Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">

   <!--/.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <div style="text-align: center;">
      <img class="img-thumbnail rounded-circle" style="width: 150px; height:150px" src="../images/logo.png" alt="">
      </div>
    
      <p class="login-box-msg mt-2">Sign in to start your session</p>

      <form action="#" method="post">
        <div class="input-group mb-3">
          <input required name="email" type="text" class="form-control" placeholder="Email / Mobile">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input name="pass" required type="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>


        <div class="input-group mb-3">
          <label for="">
          <input name="type" value="1" checked type="radio">  
          Admin</label>
        
          <label for="" style="margin-left: 20px;;">
          <input name="type" value="2" type="radio">
          Shopkeeper
          </label>
         
        </div>

        

        <div class="row">
          <div class="col-8">
            
          </div>
           <!--/.col -->
          <div class="col-4">
            <button name="submit" type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
           <!--/.col -->
        </div>
      </form>

      <!-- <p class="mb-1">-->
      <!--  <a href="forgot-password.html">I forgot my password</a>-->
      <!--</p> -->
    
    </div>
     <!--/.login-card-body -->
  </div>
</div>
 <!--/.login-box -->

 <!--jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
 <!--Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
 <!--AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>

<?php
if(isset($_POST["submit"])){
  $type = $_POST["type"]; // 1 for admin & 2 for shopkeeper
  $email=validateInput($_POST["email"]);
  $pass=Encryption::Encrypt($_POST["pass"]);

  if(trim($type) == '1'){

    $qry=DBHelper::get("SELECT * FROM `admin` WHERE email='{$email}' and pass='{$pass}' and account_status = 0");
    if($qry->num_rows > 0){

      $company = DBHelper::get("SELECT * FROM `company_info` where id = 1000")->fetch_assoc();
      $_SESSION['company'] = $company;
      $_SESSION['company_id'] = $company['id'];

      $qry=$qry->fetch_assoc();
      $_SESSION["isAdmin"]=$qry["id"];  
      $_SESSION["type"]=$qry["type"];  
      $_SESSION["user"]=$qry
      ?>
       <script>
         location.href="dashboard";
       </script>
      <?php
    }else{
       showMessage("Invalid username or password",false);
         session_destroy();
                session_unset();
    }

  }
  else{

    // shopkeeper
     $qry=DBHelper::get("SELECT * FROM `shopkeeper` WHERE mobile='{$email}' and pass='{$pass}' and status = 0");
    if($qry->num_rows > 0){

      $qry=$qry->fetch_assoc();
      $_SESSION["isAdmin"]=$qry["id"];  
      $_SESSION["user"]=$qry;  
      $_SESSION["type"]='3';  

      $company = DBHelper::get("SELECT * FROM `company_info` where id = '{$qry["company_id"]}'")->fetch_assoc();
      $_SESSION['company'] = $company;
      $_SESSION['company_id'] = $company['id'];

      ?>
       <script>
         location.href="GenerateBill";
       </script>
      <?php
    }else{
       showMessage("Invalid username or password",false);
         session_destroy();
         session_unset();
    }

  }

 
  
}
?>

<?php
if(isset($_GET["error"])){
  showMessage("Direct access is not allowed!",false);
  $_GET=[];
}
elseif(isset($_GET["expire"])){
  showMessage("Session expire kindly login again!",false);
}
?>


