<?php include("include/header.php");
$company = DBHelper::get("SELECT * FROM `company_info` where id = '{$_SESSION["company_id"]}' ")->fetch_assoc();
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
        <div class="col-sm-12 titleBackground rounded pt-1 pb-1 text-center" >
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

        <div class="d-flex mb-3 align-items-center">
           <img class="img-thumbnail" style="width:60px; height:60px;" src="c_images/<?php echo $_SESSION['company']['logo']; ?>" alt="">
           <h3 class="pl-3"><?php echo $_SESSION['company']['name'];?></h3>
        </div>

        <form method="post" enctype="multipart/form-data">
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

            <div class="form-row mb-3 ml-1">
                 <input name="file" require type="file">
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

   if(!empty($_FILES["file"]['name'])){
    if(file_exists('c_images/'.$_SESSION["company"]["logo"])){
       unlink('c_images/'.$_SESSION["company"]["logo"]);
    }

    $type=$_FILES["file"]["type"];
    $type=explode("/",$type)[1];
    $arrType=["png","jpg","jpeg","gif"];

    if(in_array($type,$arrType)){
      $imageName="comp_".time()."_".RandomString(15).".".$type;

      if(move_uploaded_file($_FILES['file']['tmp_name'],"c_images/".$imageName)){
        $q = "UPDATE `company_info` SET `name`='{$name}',`mobile`='{$mobile}',
        `email`='{$email}',`address`='{$address}',`facebook`='{$facebook}',`whatsapp`='{$whatsapp}',logo='$imageName' where id = '{$_SESSION["company_id"]}'";
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
    $q = "UPDATE `company_info` SET `name`='{$name}',`mobile`='{$mobile}',
   `email`='{$email}',`address`='{$address}',`facebook`='{$facebook}',`whatsapp`='{$whatsapp}' where id = '{$_SESSION["company_id"]}'";
   }


   if(DBHelper::set($q)){

    $company = DBHelper::get("SELECT * FROM `company_info` where id = '{$_SESSION['company_id']}'")->fetch_assoc();
    $_SESSION['company'] = $company;

    showMessage("Successfully updated!",true);
   }
   else{
       showMessage("Something went wrong try again",false);
   }
}
?>