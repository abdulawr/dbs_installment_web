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
        <div class="col-sm-12 titleBackground rounded pt-1 pb-1 text-center">
            <h1>Add new shopkeeper</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-body">

        <div id="login_details" class="mb-4" style="display: none;">
        <h5 class="bg-warning p-1 pl-4">Shopkeeper login details</h5>
        <p class="pt-0 pb-0 mb-0"><b>Username: </b><span id="username" class="pl-2">098234098234098</span></p>
        <p class="pt-0 pb-0 mb-0"><b>Password: </b><span id="passwords" class="pl-2">098234098234098</span></p>
        </div>

        <form method="post" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-4">
                <label for="inputEmail4">Name</label>
                <input name="name" required type="text" class="form-control" id="inputEmail4" placeholder="Name">
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
                <label for="inputAddress">Address</label>
                <input name="address" required type="text" class="form-control" id="inputAddress" placeholder="Address">
            </div>

            <div class="form-group">
                <label for="inputAddress">Salary</label>
                <input name="salary" required type="number" class="form-control" id="inputAddress" placeholder="Salary....">
            </div>
            
            <div class="form-group">
                <label for="exampleFormControlFile1">CNIC Picture</label>
                <input name="file" type="file" class="form-control-file" id="exampleFormControlFile1">
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
   
 $name=$_POST["name"];
 $cnic=$_POST["cnic"];
 $mobile=$_POST["mobile"];
 $address=$_POST["address"];
 $date = date("Y-m-d");
 $salary = $_POST["salary"];
 $fileName = "null";
 

 $select=DBHelper::get("SELECT cnic from shopkeeper WHERE mobile = '{$mobile}' or cnic = '{$cnic}'");
 if($select->num_rows <= 0){
    
    if(!empty($_FILES["file"]["name"]) && $_FILES["file"]["size"] > 0){
     
        $type=$_FILES["file"]["type"];
        $type=explode("/",$type)[1];
        $fileName = "shopkeeper_".$mobile."_".RandomString(15)."_".time().".".$type;
        move_uploaded_file($_FILES['file']['tmp_name'], "../images/shopkeeper/".$fileName);
     }

     $pass = RandomString(6);
     $engPass = Encryption::Encrypt($pass);
     if(DBHelper::set("INSERT INTO `shopkeeper`(`name`, `mobile`, `cnic`, `address`, `salary`, `pass`, `image`, `join_date`,company_id) VALUES ('{$name}','{$mobile}','{$cnic}','{$address}',$salary,'{$engPass}','{$fileName}','{$date}','{$_SESSION["company_id"]}')")){
      showMessage("Account created successfully \n Username = {$mobile} \n Password = {$pass}");
      ?>
      <script>
          $("#login_details").show();
          $("#username").text("<?php echo $mobile;?>");
          $("#passwords").text("<?php echo $pass;?>");
      </script>
      <?php
    }
     else{
         showMessage("Something went wrong try again");
     }

 }
 else{
   showMessage("Account already exist (mobile and cnic must be unique",false);
 }
}
?>
