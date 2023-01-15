<?php include("include/header.php");?>

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
            <h1>Add New Company</h1>
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
                <input required name="name" type="text" class="form-control" id="inputEmail4" >
                </div>
                <div class="form-group col-md-4">
                <label for="inputPassword4">Mobile</label>
                <input required name="mobile" type="number" class="form-control" id="inputPassword4" >
                </div>
                <div class="form-group col-md-4">
                <label for="inputPassword4">G-mail</label>
                <input required name="email" type="email" class="form-control" id="inputPassword4" >
                </div>
            </div>
            <div class="form-group">
                <label for="inputAddress">Address</label>
                <input required name="address" type="text" class="form-control" id="inputAddress" >
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                <label for="inputCity">Facebook</label>
                <input required name="facebook" type="text" class="form-control" id="inputCity" >
                </div>
                
                <div class="form-group col-md-6">
                <label for="inputCity">What`s App</label>
                <input required name="whatsapp" type="number" class="form-control" id="inputCity" >
                </div>

            </div>

            <div class="form-row mb-3 ml-1">
                 <input name="file" required require type="file">
            </div>
            
            <button name="submit" type="submit" class="btn btn-info">Add company</button>
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

   $check = DBHelper::get("select email from company_info where email = '$email'");

 if($check->num_rows > 0){
    showMessage("Email address should be unique, try with different email!",false);
 }
else{

      $type=$_FILES["file"]["type"];
      $type=explode("/",$type)[1];
      $arrType=["png","jpg","jpeg","gif"];

    if(in_array($type,$arrType)){
        $imageName="comp_".time()."_".RandomString(15).".".$type;
        if(move_uploaded_file($_FILES['file']['tmp_name'],"c_images/".$imageName)){
        
          $q="insert into company_info(
            name,
            mobile,
            email,
            address,
            facebook,
            whatsapp,
            logo
            )
            value(
                '$name',
                '$mobile',
                '$email',
                '$address',
                '$facebook',
                '$whatsapp',
                '$imageName'
            );";

          if(DBHelper::set($q)){
            $con=$GLOBALS["con"];
            $lastID = $con->insert_id;
            DBHelper::set("INSERT INTO `company_account`(`amount`, `id`) VALUES (0,$lastID)");
            DBHelper::set("INSERT INTO `dbs_shop_account`(`balance`, `status`, `company_id`) VALUES (0,0,'$lastID')");
            DBHelper::set("INSERT INTO `dbs_shop_account`(`balance`, `status`, `company_id`) VALUES (0,1,'$lastID')");
             showMessage("Company added successfully",true);
          }
          else{
            showMessage("Error occured while create new company",false);
          }
        }
        else{
            showMessage("Image can`t be upload right now try later",false);   
        }
    }
    else{
       showMessage("Invalid image type is provided only (png, gif, jpg, jpeg) are supported",false);
    }


}
}
?>