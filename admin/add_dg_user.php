<?php include("include/header.php") ;?>

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
        <div class="col-sm-12 rounded titleBackground pt-1 pb-1 text-center">
            <h1>Add DigiKhata User</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-body">

        <form method="post" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-4">
                <label for="inputEmail4">Name<sup class="text-danger">*</sup></label>
                <input name="name" required type="text" class="form-control" maxlength="100" id="inputEmail4" placeholder="Name....">
                </div>
                
                <div class="form-group col-md-4">
                <label for="inputPassword4">CNIC<sup class="text-danger">*</sup></label>
                <input name="cnic" required type="number" maxlength="15" class="form-control" id="inputPassword4" placeholder="CNIC">
                </div>
                <div class="form-group col-md-4">
                <label for="inputPassword4">Mobile<sup class="text-danger">*</sup></label>
                <input name="mobile" required type="number" maxlength="15" class="form-control" id="inputPassword4" placeholder="Mobile">
                </div>
            </div>

            <button name="submit" type="submit" class="btn btn-outline-primary">Add user</button>
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
if(isset($_POST["submit"]) && isset($_POST["name"])){
 $name=DBHelper::escape($_POST["name"]);
 $cnic=DBHelper::escape($_POST["cnic"]);
 $mobile=DBHelper::escape($_POST["mobile"]);


$select = DBHelper::get("SELECT * from dg_user WHERE cnic='{$cnic}' or phone='{$cnic}'");

if ($select->num_rows <= 0) {
   
    if(DBHelper::set("INSERT INTO `dg_user`(`name`, `cnic`, `phone`) VALUES ('{$name}','{$cnic}','{$mobile}')")){
        showMessage("Customer Added Successfully!",true);    
     }   
     else{
        showMessage("Data can`t be inserted right now try again later",false);    
     }
}
else{
  $customer = $select->fetch_assoc();
  showMessage("User with CNIC: ".$customer["cnic"]." or Mobile no: ".$customer["phone"]." already register with ID: ".$customer["id"],false);
}
 
}
?>
