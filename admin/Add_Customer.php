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
            <h1>Add New Customer</h1>
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
                <input name="name" required type="text" class="form-control" id="inputEmail4" placeholder="Name....">
                </div>
                
                <div class="form-group col-md-4">
                <label for="inputPassword4">CNIC</label>
                <input name="cnic" required type="number" maxlength="13" class="form-control" id="inputPassword4" placeholder="CNIC">
                </div>
                <div class="form-group col-md-4">
                <label for="inputPassword4">Mobile</label>
                <input name="mobile" required type="number" maxlength="11" class="form-control" id="inputPassword4" placeholder="Mobile">
                </div>
            </div>

            <div class="form-group">
                <label for="inputEmail4">Father Name</label>
                <input name="fname" required type="text" class="form-control" id="inputEmail4" placeholder="Father Name....">
            </div>

            <div class="form-group">
                <label for="inputAddress">Address</label>
                <input name="address" required type="text" class="form-control" id="inputAddress" placeholder="Address....">
            </div>
            
            <div class="form-group">
                <label for="exampleFormControlFile1">CNIC Picture</label>
                <input name="file" required type="file" class="form-control-file" id="exampleFormControlFile1">
            </div>

            <button name="submit" type="submit" class="btn btn-info">Submit</button>
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
 $fname=DBHelper::escape($_POST["fname"]);
 $cnic=DBHelper::escape($_POST["cnic"]);
 $mobile=DBHelper::escape($_POST["mobile"]);
 $address=DBHelper::escape($_POST["address"]);
 
 $type=$_FILES["file"]["type"];
$type=explode("/",$type)[1];
$arrType=["png","jpg","jpeg","gif"];

$select=DBHelper::get("SELECT cnic  from customer WHERE cnic='{$cnic}'");
if ($select->num_rows <= 0) {
    if (in_array($type, $arrType)) {
        $imageName="customer_".$cnic.RandomString(15).".".$type;
        if (move_uploaded_file($_FILES['file']['tmp_name'], "../images/customer/".$imageName)) {
            if(DBHelper::set("INSERT INTO `customer`(fname,`name`, `cnic`, `mobile`, `address`, `image`,company_id) VALUES ('{$fname}','{$name}','{$cnic}','{$mobile}','{$address}','{$imageName}','{$_SESSION["company_id"]}')")){
                showMessage("Customer Added Successfully!",true);    
             }   
             else{
                showMessage("Data can`t be inserted right now try again later",false);    
             }
        }
        else{
            showMessage("Error occured while uploading image",false);
        }
    }
    else{
        showMessage("Invalid image type only (png, jpg,jpeg) is supported",false);
    }
}
else{
    showMessage("Customer with this CNIC exist",false);
}
 
}
?>
