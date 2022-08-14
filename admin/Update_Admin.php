<?php include("include/header.php");
$admin=DBHelper::get("SELECT * FROM `admin` WHERE id={$_SESSION["isAdmin"]}")->fetch_assoc();
?>

<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <!-- Navbar -->
  <?php include("include/nav.php");?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include("include/slide.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8 bg-info pt-1 pb-1 text-center" style="border-top-right-radius: 500px; border-bottom-right-radius: 500px;">
            <h1 >Update Profile</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card border-right border-bottom border-info">
        <div class="card-body">

        <form enctype="multipart/form-data" method="post">

        <div class="row">
            <div class="col">
            <label for="">Name</label>
            <input required name="name" type="text" class="form-control" placeholder="Name" value="<?php echo $admin["name"];?>">
            </div>
            <div class="col">
            <label for="">Email</label>
            <input required name="email" type="email" class="form-control" placeholder="Email" value="<?php echo $admin["email"];?>">
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
            <label for="">Mobile</label>
            <input required name="mobile" type="number" class="form-control" placeholder="Mobile" value="<?php echo $admin["mobile"];?>">
            </div>
            <div class="col">
            <label for="">CNIC</label>
            <input required name="cnic" type="number" class="form-control" placeholder="CNIC" value="<?php echo $admin["cnic"];?>">
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
            <label for="">Address</label>
            <input type="text" required name="address" class="form-control" placeholder="Address" value="<?php echo $admin["address"];?>">
            </div>
            <div class="col">
            <label for="">Password</label>
            <input type="password" required name="pass" class="form-control" placeholder="Password" value="<?php echo Encryption::Decrypt($admin["pass"]);?>">
            </div>
        </div>

        <button type="submit" name="submit" class="btn btn-outline-info mt-3">Update</button>

        </form>

        </div>
        <!-- /.card-body -->
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?php include("include/footer.php");?>

</body>
</html>

<?php
if(isset($_POST["submit"])){
$name=validateInput($_POST["name"]);
$email=validateInput($_POST["email"]);
$mobile=validateInput($_POST["mobile"]);
$cnic=validateInput($_POST["cnic"]);
$address=validateInput($_POST["address"]);
$pass=Encryption::Encrypt($_POST["pass"]);

if(DBHelper::set("UPDATE `admin` SET `name`='{$name}',`mobile`='{$mobile}',`email`='{$email}',`pass`='{$pass}',`cnic`='{$cnic}',`address`='{$address}' WHERE id={$_SESSION["isAdmin"]}")){
showMessage("Account successfully updated!",true);    
}   
else{
showMessage("Data can`t be updated right now try again later",false);    
}
}
?>
