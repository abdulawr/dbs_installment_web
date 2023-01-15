<?php include("include/header.php");

$id = DBHelper::escape($_GET["ID"]);
$investor = DBHelper::get("select * from customer where id = {$id} and company_id = '{$_SESSION["company_id"]}' ")->fetch_assoc();

$customer=DBHelper::get("SELECT customer.id AS 'cusID',customer.name,customer.mobile,companies.name 
as 'comp',item_type.name as 'item',application.* from application INNER JOIN 
customer on customer.id = cusID INNER JOIN companies on companies.id = companyID 
INNER JOIN item_type on item_type.id = item_type_id where cusID = {$id} and application.company_id = '{$_SESSION["company_id"]}' ");

?>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <?php include("include/nav.php");?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include("include/slide.php");?>
  <?php include("include/image_model.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper mt-4">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img onclick="ShowImage(this.src)" class="profile-user-img img-fluid img-circle"
                       src="../images/customer/<?php echo $investor["image"]."?".rand(100,1000);?>"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo $investor["name"];?></h3>
                <p class="text-muted text-center text-danger">Customer</p>

              <!--   <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Followers</b> <a class="float-right">1,322</a>
                  </li>
                  <li class="list-group-item">
                    <b>Following</b> <a class="float-right">543</a>
                  </li>
                  <li class="list-group-item">
                    <b>Friends</b> <a class="float-right">13,287</a>
                  </li>
                </ul> -->

                <a href="Customer_Application.php?ID=<?php echo $investor["id"];?>" class="btn btn-info btn-block"><b>New Application</b></a>
              
            </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Customer Details</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> CNIC</strong>

                <p class="text-muted">
                 <?php echo $investor["cnic"];?>
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>

                <p class="text-muted"><?php echo $investor["address"];?></p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Mobile</strong>

                <p class="text-muted">
                <?php echo $investor["mobile"];?>
                </p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Father</strong>

                  <p class="text-muted">
                  <?php echo $investor["fname"];?>
                  </p>

                  <hr>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Application</a></li>
                 
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Profile</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                  
                  <table id="example2" class="table table-bordered table-hover mt-3">
                  <thead>
                  <tr>
                    <th>Item name</th>
                    <th>Model No</th>
                    <th>Type</th>
                    <th>Company</th>
                    <th>Total Price</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                 
                <?php
                    if($customer->num_rows > 0){
                        while($row=$customer->fetch_assoc()){
                        ?>
                     <tr>
                        <td><?php echo $row["product_name"];?></td>
                        <td><?php echo $row["model_no"];?></td>
                        <td><?php echo $row["item"];?></td>
                        <td><?php echo ucfirst($row["comp"]);?></td>
                        <td><?php echo $row["total_price"];?></td>
                        <td><?php echo date("d-m-Y",strtotime($row["date"]));?></td>
                        <td style="text-align: center;">
                        <?php
                        switch($row["status"]){
                            case 0:
                                ?>
                                  <span class="bg-info p-1 rounded">Pending</span>
                                <?php
                                break;
                            case 1:
                                ?>
                                 <span class="bg-primary p-1 rounded">Accepted</span>
                                <?php
                                break;
                            case 2:
                                ?>
                                 <span class="bg-danger p-1 rounded">Delivered</span>
                                <?php
                                break;
                            case 3:
                                ?>
                                 <span class="bg-success p-1 rounded">Active</span>
                                <?php
                                break;
                            case 4:
                                ?>
                                  <span class="bg-warning p-1 rounded">Complete</span>
                                <?php
                                break;
                                case 5:
                                  ?>
                                    <span class="bg-danger p-1 rounded">Rejected</span>
                                  <?php
                                  break;
                        }
                        ?>
                        </td>
                        <td>
                            <a href="View_Application?ID=<?php echo $row["id"];?>" class="btn-sm btn-info">Details</a>
                         
                        </td>
                    </tr>
                        <?php
                        }
                    }
                ?>
                 
                  </tbody>
                
                </table>

                  
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal" method="post" enctype="multipart/form-data">
                      <div class="form-group row">
                          <input name="id" type="hidden" value="<?php echo $investor["id"];?>">
                          <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                          <div class="col-sm-10">
                        <input required  name="name" type="text" class="form-control" id="inputName" placeholder="نام" value="<?php echo $investor["name"];?>">
                        </div>
                      
                      </div>

                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">CNIC</label>
                        <div class="col-sm-10">
                          <input required name="cnic" type="number" class="form-control" id="inputEmail" placeholder="CNIC" value="<?php echo $investor["cnic"];?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Mobile</label>
                        <div class="col-sm-10">
                          <input required name="mobile" type="number" class="form-control" id="inputName2" placeholder="Mobile" value="<?php echo $investor["mobile"];?>">
                        </div>
                      </div>
                      <div class="form-group row">
                       
                      <label for="inputExperience" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10">
                          <textarea required name="address" class="form-control" id="inputExperience" placeholder="گھر کا پتہ"><?php echo $investor["address"];?></textarea>
                        </div>
                      
                      </div>

                      <input type="file" class="mb-3" name="investorImage">
  
                      <div class="form-group row">
                        <div class="offset-sm-0 col-sm-12">
                          <button name="submit" type="submit" class="btn btn-info">Update</button>
                        </div>
                      </div>

                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
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
<?php include("include/footer.php");?>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
<script src="dist/js/adminlte.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

</body>
</html>

<script>
   function ShowImage(value){
    let image = $("#imageView");
    image.prop("src",value);
    $('#imageModel').modal({
    keyboard: false,
    show: true
    })
   }
</script>

<?php
if(isset($_POST["submit"])){
    $name = $_POST["name"];
    $cnic= $_POST["cnic"];
    $mobile = $_POST["mobile"];
    $address = $_POST["address"];
    $id = $_POST["id"];

    $file = $_FILES["investorImage"];

    if(DBHelper::set("UPDATE `customer` SET `name`='{$name}',`cnic`='{$cnic}',`mobile`='{$mobile}',`address`='{$address}' WHERE id =$id and company_id = '{$_SESSION["company_id"]}' ")){
     
      if(!empty($file["name"]) && $file["size"] > 0){
        $fileName = explode(".",$investor["image"])[0];
        $ff = explode(".",$investor["image"])[0];
        $ttps = explode(".",$investor["image"])[1];
        $type=$file["type"];
        $type=explode("/",$type)[1];
        $fileName .=".".$type;

        if(move_uploaded_file($file["tmp_name"],"../images/customer/".$fileName)){
          DBHelper::set("UPDATE `customer` SET `image`='{$fileName}' where id = {$id} and company_id = '{$_SESSION["company_id"]}'");
          if(trim($ttps) != trim($type)){
            unlink("../images/customer/".$ff.".".$ttps);
          }
        }
      }
      showMessage("Customer account updated successfully",true);
    }
    else{
        showMessage("Something went wrong in updating the customer",false);
    }
}
?>