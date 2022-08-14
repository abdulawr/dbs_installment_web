<?php include("include/header.php");
$company=DBHelper::get("SELECT * FROM `company_info`")->fetch_assoc();
;?>

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
            <h1>Update Company Info</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-body">

        <form method="post">
            <div class="form-row">
                <div class="form-group col-md-4">
                <label for="inputEmail4">Name</label>
                <input required name="name" type="text" class="form-control" id="inputEmail4" value="<?php echo $company["name"];?>">
                </div>
                <div class="form-group col-md-4">
                <label for="inputPassword4">Mobile</label>
                <input required name="mobile" type="number" class="form-control" id="inputPassword4" value="<?php echo $company["mobile"];?>">
                </div>
                <div class="form-group col-md-4">
                <label for="inputPassword4">G-mail</label>
                <input required name="email" type="email" class="form-control" id="inputPassword4" value="<?php echo $company["email"];?>">
                </div>
            </div>
            <div class="form-group">
                <label for="inputAddress">Address</label>
                <input required name="address" type="text" class="form-control" id="inputAddress" value="<?php echo $company["address"];?>">
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                <label for="inputCity">Facebook</label>
                <input required name="facebook" type="text" class="form-control" id="inputCity" value="<?php echo $company["facebook"];?>">
                </div>
                
                <div class="form-group col-md-6">
                <label for="inputCity">What`s App</label>
                <input required name="whatsapp" type="number" class="form-control" id="inputCity" value="<?php echo $company["whatsapp"];?>">
                </div>

            </div>
            
            <button name="submit" type="submit" class="btn btn-info">Update</button>
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
   $mobile=validateInput($_POST["mobile"]);
   $email=validateInput($_POST["email"]);
   $address=validateInput($_POST["address"]);
   $facebook=validateInput($_POST["facebook"]);
   $whatsapp=validateInput($_POST["whatsapp"]);

   if(DBHelper::set("UPDATE `company_info` SET `name`='{$name}',`mobile`='{$mobile}',`email`='{$email}',`address`='{$address}',`facebook`='{$facebook}',`whatsapp`='{$whatsapp}'")){
    showMessage("Successfully updated!",true);
   }
   else{
       showMessage("Something went wrong try again",false);
   }
}
?>