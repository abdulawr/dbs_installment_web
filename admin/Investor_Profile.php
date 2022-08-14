<?php include("include/header.php");
$id = $_GET["ID"];
$investor = DBHelper::get("select * from investor where id = {$id}")->fetch_assoc();
$balance = DBHelper::get("SELECT balance FROM `investor_account` WHERE investorID = {$investor["id"]}")->fetch_assoc()["balance"];
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
                       src="../images/investor/<?php echo $investor["image"]."?".rand(100,1000);?>"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo $investor["name"];?></h3>

                <p class="text-muted text-center">Investor</p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Balance</b> <a class="float-right"><?php echo $balance;?></a>
                  </li>
                 
                </ul>

                <button onclick="submitAccount(0)" data-toggle="modal" data-target="#modal-balance" class="btn btn-primary btn-block"><b>Add balance</b></button>
                <?php
                if($balance > 0){
                  ?>
                <button onclick="submitAccount(1)" data-toggle="modal" data-target="#modal-balance" class="btn btn-warning btn-block"><b>Subtract balance</b></button>
                  <?php
                }
                
                ?>

                <div class="modal fade" id="modal-balance">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Add balance</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                     <form action="model/investorBalance" method="post">
                       <input name="amount" required type="number" class="form-control" placeholder="Enter balance">
                       <textarea name="des" class="form-control mt-3" placeholder="Enter description.."></textarea>
                       <input type="hidden" name="type" id="tran_type" >
                       <input type="hidden" name="ID" value="<?php echo $investor["id"]; ?>">
                       <button type="submit" name="submit" class="btn btn-info mt-4">Submit</button>
                     </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
               
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Investor Details</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> CNIC</strong>

                <p class="text-muted">
                 <?php echo $investor["cnic"];?>
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>

                <p class="text-muted urdu"><?php echo $investor["address"];?></p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Mobile</strong>

                <p class="text-muted">
                <?php echo $investor["mobile"];?>
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
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Users</a></li>
                  <li class="nav-item"><a class="nav-link " href="#pendingPay" data-toggle="tab">Pending Payments</a></li>
                  <li class="nav-item"><a class="nav-link " href="#application" data-toggle="tab">Application</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Transactions</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Profile</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">


                  <div class="active tab-pane" id="activity">
                  <div class="card">
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Mobile</th>
                      <th>CNIC</th>
                      <th>Applicatin ID</th>
                    
                      <th style="width: 40px">Action</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                  $data = DBHelper::get("SELECT customer.*,application.id as 'appID' from customer INNER JOIN application ON customer.id = cusID WHERE application.investorID = {$id};");
                  if ($data->num_rows > 0) {
                      while ($row = $data->fetch_assoc()) {
                        ?>
                          <tr>
                          <td><?php echo $row["id"];?></td>
                          <td><?php echo $row["name"];?></td>
                          <td><?php echo $row["cnic"];?></td>
                          <td><?php echo $row["mobile"];?></td>
                          <td><?php echo $row["appID"];?></td>
                          
                          <td style="width:20%">
                                <a class="btn btn-info btn-sm" href="View_Application?ID=<?php echo $row["appID"]; ?>">
                                <i class="nav-icon fas fa-file-pdf"></i>
                                </a>
                                <a class="btn btn-primary btn-sm" href="Customer_Profile?ID=<?php echo $row["id"];?>">
                                <i class="nav-icon fas fa-user"></i>
                                </a>
                             
                          </td>
                        </tr>
                        <?php
                      }
                  }
                  ?>

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
                  </div>


              <div class="tab-pane" id="pendingPay">

              <div class="card">
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr >
                      <th>Invest amount</th>
                      <th>Date</th>
                      <th>Profit</th>
                      <th>Total</th>
                      <th>Cus ID</th>
                      <th>App ID</th>
                      <th>Paid</th>
                      <th>Payable</th>
                      <th style="width: 40px">Action</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                  $data = DBHelper::get("SELECT * FROM `application_investor_pending_payment` WHERE `investorID` = {$id} order by id desc;");
                  if ($data->num_rows > 0) {
                      while ($row = $data->fetch_assoc()) {
                        ?>
                          <tr class="<?php echo ($row["payable"] == "0") ? "bg-warning" : ""; ?>">
                          <td><?php echo $row["invest_amount"];?></td>
                          <td><?php echo date("d-m-Y",strtotime($row["date"]));?></td>
                          <td><?php echo $row["profit"];?></td>
                          <td><?php echo $row["total_amount"];?></td>
                          <td><?php echo $row["cusID"];?></td>
                          <td><?php echo $row["appID"];?></td>
                          <td><?php echo $row["paid"];?></td>
                          <td><?php echo $row["payable"];?></td>

                          <td>
                            <?php
                            if(trim($row["payable"]) > 0) {
                              ?>
                                <a class="btn btn-success btn-sm" href="AddInvestorPendingAmount?ID=<?php echo $row["id"]."&investID=".$id;?>">Add</a>
                              <?php
                            }
                            ?>
                          
                          </td>
                        </tr>
                        <?php
                      }
                  }
                  ?>

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
                 
          </div>


                 <div class="tab-pane" id="application">

                 <div class="card">
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Date</th>
                      <th>Company</th>
                      <th>Type</th>
                      <th>Model</th>
                      <th>T-amount</th>
                      <th>Status</th>
                      <th style="width: 40px">Action</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                  $data =$app = DBHelper::get("SELECT companies.name as 'comp',item_type.name as 'item',application.* from application INNER JOIN companies on companies.id = companyID INNER JOIN item_type on item_type.id = item_type_id WHERE application.investorID = {$id}");
                  if ($data->num_rows > 0) {
                      while ($row = $data->fetch_assoc()) {
                        ?>
                          <tr>
                          <td><?php echo $row["id"];?></td>
                          <td><?php echo date("d-m-Y",strtotime($row["date"]));?></td>
                          <td><?php echo ucfirst($row["comp"]);?></td>
                          <td><?php echo $row["item"];?></td>
                          <td><?php echo $row["model_no"];?></td>
                          <td><?php echo $row["total_price"];?></td>

                          <td>
                            <?php
                            if($row["status"] == 0){
                             ?>
                              <span class="badge bg-info">Pending</span>
                             <?php
                            }
                            elseif($row["status"] == 1){
                              ?>
                               <span class="badge bg-primary">Accepted</span>
                              <?php
                            }
                            elseif($row["status"] == 3){
                              ?>
                               <span class="badge bg-success">Active</span>
                             <?php
                            }
                            elseif($row["status"] == 4){
                              ?>
                                <span class="badge bg-warning">Completed</span>
                              <?php 
                            }
                            ?>
                          </td>

                          <td>
                                <a class="btn btn-info btn-sm" href="View_Application?ID=<?php echo $row["id"]; ?>">View</a>
                          
                          </td>
                        </tr>
                        <?php
                      }
                  }
                  ?>

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
                 
                 </div>


                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                  
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Transaction History</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">ID</th>
                      <th>Amount</th>
                      <th>Date</th>
                      <th>Admin name</th>
                      <th>Admin cnic</th>
                      <th>Details</th>
                      <th style="width: 40px">Type</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                  $data = DBHelper::get("SELECT investor_transaction.*,admin.name,admin.cnic FROM investor_transaction  INNER JOIN admin on adminID = admin.id WHERE investorID = {$investor["id"]} order by investor_transaction.id desc");
                  if ($data->num_rows > 0) {
                      while ($row = $data->fetch_assoc()) {
                        ?>
                          <tr>
                          <td><?php echo $row["id"];?></td>
                          <td><?php echo $row["amount"];?></td>
                          <td><?php echo $row["date"];?></td>
                          <td><?php echo $row["name"];?></td>
                          <td><?php echo $row["cnic"];?></td>
                          <td><?php echo $row["des"];?></td>
                          <td><span class="badge <?php echo ($row["type"] == 0) ? "bg-success":"bg-warning";?>">
                          <?php echo ($row["type"] == 0) ? "Added":"Subtracted";?></span></td>
                        </tr>
                        <?php
                      }
                  }
                  ?>

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>

                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal" method="post" enctype="multipart/form-data">
                      <div class="form-group row">
                        
                      <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input name="name" required type="name" class="form-control" id="inputName" placeholder="نام" value="<?php echo $investor["name"];?>">
                        </div>
                       
                      </div>

                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">CNIC</label>
                        <div class="col-sm-10">
                          <input name="cnic" required type="number" class="form-control" id="inputEmail" placeholder="CNIC" value="<?php echo $investor["cnic"];?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Mobile</label>
                        <div class="col-sm-10">
                          <input name="mobile" required type="number" class="form-control" id="inputName2" placeholder="Mobile" value="<?php echo $investor["mobile"];?>">
                        </div>
                      </div>
                      <div class="form-group row">
                       
                      <label for="inputExperience" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10">
                          <textarea name="address" required class="form-control " id="inputExperience" placeholder="گھر کا پتہ"><?php echo $investor["address"];?></textarea>
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
    $file = $_FILES["investorImage"];
    $name = $_POST["name"];
    $cnic= $_POST["cnic"];
    $mobile = $_POST["mobile"];
    $address = $_POST["address"];
    $id = $investor["id"];

    if(DBHelper::set("UPDATE `investor` SET `name`='{$name}',`cnic`='{$cnic}',`mobile`='{$mobile}',`address`='{$address}' WHERE id =$id ")){
      if(!empty($file["name"]) && $file["size"] > 0){
        $fileName = explode(".",$investor["image"])[0];
        $type=$file["type"];
        $ff = explode(".",$investor["image"])[0];
        $ttps = explode(".",$investor["image"])[1];
        $type=explode("/",$type)[1];
        $fileName .=".".$type;
        if(move_uploaded_file($file["tmp_name"],"../images/investor/".$fileName)){
          DBHelper::set("UPDATE `investor` SET `image`='{$fileName}' where id = {$id}");
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

<script>
  function submitAccount(ty){
    var type = ty;
    $("#tran_type").val(ty);
  }
</script>