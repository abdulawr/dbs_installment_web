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
          <div class="col-sm-8 bg-info pt-1 pb-1 text-center" style="border-top-right-radius: 500px; border-bottom-right-radius: 500px;">
            <h1 >Add Admin</h1>
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
            <input required name="name" type="text" class="form-control" placeholder="Name">
            </div>
            <div class="col">
            <label for="">Email</label>
            <input required name="email" type="email" class="form-control" placeholder="Email">
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
            <label for="">Mobile</label>
            <input required name="mobile" type="number" class="form-control" placeholder="Mobile">
            </div>
            <div class="col">
            <label for="">CNIC</label>
            <input required name="cnic" type="number" class="form-control" placeholder="CNIC">
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
            <label for="">Address</label>
            <input type="text" required name="address" class="form-control" placeholder="Address">
            </div>
            <div class="col">
            <label for="">Password</label>
            <input type="password" required name="pass" class="form-control" placeholder="Password">
            </div>
        </div>

        <div class="form-group mt-3">
            <label for="exampleFormControlSelect1">Select Role</label>
            <select name="type" class="form-control" id="roleSelect">
            <option value="1">Super Admin</option>
            <option value="2">Sub Admin</option>
            </select>
        </div>

        <?php
              $company = DBHelper::get("SELECT * FROM `company_info` order by id asc");
        ?>

        <div class="form-group mt-3">
            <label for="exampleFormControlSelect1">Select Company</label>
            <select disabled name="company_id" class="form-control" id="compIDSelect">
               <?php
                  while($row = $company->fetch_assoc()){
                    echo '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                  }
               ?>
            </select>
        </div>

        <div class="form-group">
            <label for="exampleFormControlFile1">Choose Profile Image</label>
            <input required name="file" type="file" class="form-control-file" id="exampleFormControlFile1">
        </div>

        <button type="submit" name="submit" class="btn btn-outline-info">Submit</button>

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

<script>
  $("#roleSelect").on("change",function(){
    var sele = $('#roleSelect').find(":selected").val();
     if(sele == 2){
       $('#compIDSelect').removeAttr('disabled'); 
     }
     else{
       $("#compIDSelect").attr('disabled', 'disabled');
     }
  });
</script>

<?php
if(isset($_POST["submit"])){
$name=validateInput($_POST["name"]);
$email=validateInput($_POST["email"]);
$mobile=validateInput($_POST["mobile"]);
$cnic=validateInput($_POST["cnic"]);
$address=validateInput($_POST["address"]);
$admin_type=validateInput($_POST["type"]);
$pass=Encryption::Encrypt($_POST["pass"]);

$company_id = ($admin_type == 2) ? $_POST["company_id"] : "1000";

$type=$_FILES["file"]["type"];
$type=explode("/",$type)[1];
$arrType=["png","jpg","jpeg","gif"];
$select=DBHelper::get("SELECT id FROM `admin` WHERE email='{$email}'");

if($select->num_rows <= 0){
    if(in_array($type,$arrType)){
        $imageName="admin_".$mobile.RandomString(15).".".$type;
        if(move_uploaded_file($_FILES['file']['tmp_name'],"../images/admin/".$imageName)){
         if(DBHelper::set("INSERT INTO `admin`(`name`, `mobile`, `email`, `pass`, `image`, `cnic`, `address`, `type`,company_id) VALUES ('{$name}','{$mobile}','{$email}','{$pass}','{$imageName}','{$cnic}','{$address}',$admin_type,$company_id)")){
            showMessage("Account created successfully!",true);    
         }   
         else{
            showMessage("Data can`t be inserted right now try again later",false);    
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
else{
    showMessage("Account already exist",false); 
}
}
?>
