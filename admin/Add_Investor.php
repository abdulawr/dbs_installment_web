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
            <h1>Add Investor</h1>
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
        <label for="inputEmail4">Name</label>
        <input name="name" required type="text" class="form-control" id="inputEmail4" placeholder="Name">
        </div>
        <div class="form-group col-md-4">
        <label for="inputPassword4">CNIC</label>
        <input name="cnic" required type="number" class="form-control" maxlength="13" id="inputPassword4" placeholder="CNIC">
        </div>
        <div class="form-group col-md-4">
        <label for="inputPassword4">Mobile</label>
        <input name="mobile" required type="number" maxlength="11" class="form-control" id="inputPassword4" placeholder="Mobile no">
        </div>
            </div>
        <div class="form-group">
            <label for="inputAddress">Address</label>
            <input required name="address" type="text" class="form-control" id="inputAddress" placeholder="Address">
        </div>

        <div class="form-group">
            <label for="exampleFormControlFile1">Profile Image</label>
            <input name="file" accept=".png,.jpg,.jpeg,.gif" required type="file" class="form-control-file" id="exampleFormControlFile1">
        </div>

        <button name="addInverstor" type="submit" class="btn btn-outline-success">Submit</button>
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
if (isset($_POST["addInverstor"])) {
  $name = $_POST["name"];
  $cnic = $_POST["cnic"];
  $mobile = $_POST["mobile"];
  $address = $_POST["address"];
  
  $file = $_FILES["file"];
  $fileType = explode("/",$file["type"])[1];
  $filename=RandomString(50).".".$fileType;
  
  $check = DBHelper::get("SELECT id FROM `investor` WHERE cnic = '{$cnic}' and company_id = '{$_SESSION["company_id"]}'");
  if($check->num_rows > 0){
   showMessage("Account already exist with this CNIC",false);
  }
  else{
    if(move_uploaded_file($file["tmp_name"],"../images/investor/".$filename)){
      if(DBHelper::set("INSERT INTO `investor`(`name`, `cnic`, `mobile`, `address`, `image`,company_id) VALUES ('{$name}','{$cnic}','{$mobile}','{$address}','{$filename}','{$_SESSION["company_id"]}')")){ 
        $investor_id = $con->insert_id;
        DBHelper::set("INSERT INTO investor_account (investorID,company_id) VALUES({$investor_id},'{$_SESSION["company_id"]}')");
        showMessage("Investor is added successfully!",true);
      }
      else{
        unlink("../images/investor/".$filename);
       showMessage("Data can`t be inserted into database",false);
      }
     } 
     else{
       showMessage("Image is not uploaded try again",false);
     }
  }
} 
?>
