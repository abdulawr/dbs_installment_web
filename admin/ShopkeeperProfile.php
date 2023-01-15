<?php include("include/header.php");
$id = DBHelper::escape($_GET["ID"]);
$investor = DBHelper::get("select * from shopkeeper where id = {$id} and company_id = '{$_SESSION["company_id"]}'")->fetch_assoc();
$balance = DBHelper::get("SELECT SUM(amount) as total FROM `accessories_account` WHERE status = 0 and type = 0 and sellID = {$id}")->fetch_assoc()["total"];
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

          <?php
          if($investor["image"] == "null" || empty($investor["image"])){
            $investor["image"] = "no_image.jpg"; 
          }
          ?>

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img onclick="ShowImage(this.src)" class="profile-user-img img-fluid img-circle"
                       src="../images/shopkeeper/<?php echo $investor["image"];?>"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo $investor["name"];?></h3>

                <p class="text-muted text-center">
                   Shopkeeper
                </p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Balance</b> <a class="float-right"><?php echo $balance;?></a>
                  </li>
                 
                </ul>

                <?php
               
                  if ($investor["status"] == 0) {
                      ?>
                   <a href="model/blockShopkeeperAccount.php?status=1&id=<?php echo $investor["id"];?>"  class="btn btn-danger text-white btn-block"><b>Block It</b></a>
                  <?php
                  }
                  else{
                    ?>
                    <a href="model/blockShopkeeperAccount.php?status=0&id=<?php echo $investor["id"];?>"   class="btn btn-warning btn-block"><b>Allow It</b></a>
                   <?php  
                  }
                
                
                ?>
               
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Admin Details</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> CNIC</strong>

                <p class="text-muted">
                 <?php echo $investor["cnic"];?>
                </p>

                <hr>

                <strong><i class="fas fa-book mr-1"></i> Salary</strong>

                <p class="text-muted">
                 <?php echo $investor["salary"];?>
                </p>

                <hr>

                <strong><i class="fas fa-book mr-1"></i> Password</strong>

                <p class="text-muted">
                <?php echo Encryption::Decrypt($investor["pass"]);?>
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>

                <p class="text-muted "><?php echo $investor["address"];?></p>

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
                <!--   <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Pending Payments</a></li>
                  <li class="nav-item"><a class="nav-link " href="#pendingPay" data-toggle="tab">History</a></li> -->
               <!--    <li class="nav-item"><a class="nav-link " href="#application" data-toggle="tab">Application</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Transactions</a></li> -->
                  <li class="nav-item"><a class="nav-link active" href="#pendingAmount" data-toggle="tab">Accessory Pending Amount</a></li> 
                  <li class="nav-item"><a class="nav-link" href="#accHistory" data-toggle="tab">Accessory History</a></li> 
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Profile</a></li> 
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">


                  <div class="tab-pane" id="activity">
                  <div class="card">
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Amount</th>
                      <th>Date</th>
                      <th>Type</th>
                      <th>Transcation Type</th>
                      <th>Applicatin ID</th>
                    
                      <th style="width: 40px">Action</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                  $data = DBHelper::get("SELECT * from admin_transaction WHERE adminID = {$id} and paymentStatus = 0 order by id desc");
                  if ($data->num_rows > 0) {
                      while ($row = $data->fetch_assoc()) {
                        ?>
                          <tr>
                          <td><?php echo $row["amount"];?></td>
                          <td><?php echo date("d-m-Y",strtotime($row["date"]));?></td>
                          <td>
                              <?php
                              if($row["type"] == "investor"){
                                echo '<span class="badge badge-primary">Investor</span>';
                              }
                              elseif($row["type"] == "customer"){
                                echo '<span class="badge badge-dark">Customer</span>';
                              }
                              else{
                                echo '<span class="badge badge-warning">Expence</span>';
                              }
                              ?>
                          </td>

                          <td>
                          <?php
                              if($row["status"] == 0){
                                echo '<span class="badge badge-primary">Added investor</span>';
                              }
                              elseif($row["status"] == 1){
                                echo '<span class="badge badge-danger">Sub investor</span>';
                              }
                              elseif($row["status"] == 2){
                                echo '<span class="badge badge-success">Application installment</span>';
                              }
                              else{
                                echo '<span class="badge badge-info">Company cost</span>';
                              }
                              ?>
                          </td>

                          <td>
                              <?php
                             if($row["type"] == "customer"){
                                echo $row["appID"];
                              } 
                              else{
                                  echo "---";
                              } 
                              ?>
                          </td>
                          
                          <td style="width:20%">
                                <a href="model/adminTransStatusChange.php?ID=<?php echo $row["id"]."&adminID=".$investor["id"];?>" class="btn-sm btn-warning" href="View_Application?ID=<?php echo $row["appID"]; ?>">
                                 Received
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
                    <tr>
                      <th>Amount</th>
                      <th>Date</th>
                      <th>Type</th>
                      <th>Transcation Type</th>
                      <th>Applicatin ID</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                  $data = DBHelper::get("SELECT * from admin_transaction WHERE adminID = {$id} and paymentStatus = 1 order by id desc");
                  if ($data->num_rows > 0) {
                      while ($row = $data->fetch_assoc()) {
                        ?>
                          <tr>
                          <td><?php echo $row["amount"];?></td>
                          <td><?php echo date("d-m-Y",strtotime($row["date"]));?></td>
                          <td>
                              <?php
                              if($row["type"] == "investor"){
                                echo '<span class="badge badge-primary">Investor</span>';
                              }
                              elseif($row["type"] == "customer"){
                                echo '<span class="badge badge-dark">Customer</span>';
                              }
                              else{
                                echo '<span class="badge badge-warning">Expence</span>';
                              }
                              ?>
                          </td>

                          <td>
                          <?php
                              if($row["status"] == 0){
                                echo '<span class="badge badge-primary">Added investor</span>';
                              }
                              elseif($row["status"] == 1){
                                echo '<span class="badge badge-danger">Sub investor</span>';
                              }
                              elseif($row["status"] == 2){
                                echo '<span class="badge badge-success">Application installment</span>';
                              }
                              else{
                                echo '<span class="badge badge-info">Company cost</span>';
                              }
                              ?>
                          </td>

                          <td>
                              <?php
                             if($row["type"] == "customer"){
                                echo $row["appID"];
                              } 
                              else{
                                  echo "---";
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
                    <form class="form-horizontal" method="post">
                      <div class="form-group row">
                        
                      <label for="inputName" class="col-sm-2 col-form-label ">Name</label>
                        <div class="col-sm-10">
                          <input name="name" required type="name" class="form-control " id="inputName" placeholder="نام" value="<?php echo $investor["name"];?>">
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
                        <label for="inputName2" class="col-sm-2 col-form-label">Salary</label>
                        <div class="col-sm-10">
                          <input name="salary" required type="number" class="form-control" id="inputName2" placeholder="Mobile" value="<?php echo $investor["salary"];?>">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                          <input name="password" required type="text" class="form-control" id="inputName2" placeholder="Mobile" value="<?php echo Encryption::Decrypt($investor["pass"]) ;?>">
                        </div>
                      </div>

                    

                      <div class="form-group row">
                       
                      <label for="inputExperience" class="col-sm-2 col-form-label ">Address</label>
                        <div class="col-sm-10">
                          <textarea name="address" required class="form-control " id="inputExperience" placeholder="Address"><?php echo $investor["address"];?></textarea>
                        </div>
                     
                      </div>
  
                      <div class="form-group row">
                        <div class="offset-sm-0 col-sm-12">
                          <button name="submit" type="submit" class="btn btn-info">Update</button>
                        </div>
                      </div>

                    </form>
                  </div>

                  

                  <div class="active tab-pane" id="pendingAmount">
                  <!-- Accessor Pending amount -->
                  <div class="card">
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Amount</th>
                      <th>Date</th>
                      <th>Accessory ID</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                  $data = DBHelper::get("SELECT * FROM `accessories_account` WHERE status = 0 and type = 0 and sellID = {$id}");
                  if ($data->num_rows > 0) {
                      while ($row = $data->fetch_assoc()) {
                        ?>
                          <tr>
                          <td><?php echo $row["amount"];?></td>
                          <td><?php echo date("d-m-Y",strtotime($row["date"]));?></td>
                          <td><?php echo $row["accessID"];?></td>
                          <td>
                            <?php if($_SESSION["type"] == "1"){ ?>
                            <a href="model/ReceivedAccessoryAmount.php?id=<?php echo $row['id'].'&userID='.$id; ?>" class="btn btn-warning btn-sm">Received</a>
                            <?php } ?>

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


                  <div class="tab-pane" id="accHistory">
                  <!-- Accessory History -->

                  <div class="card">
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Amount</th>
                      <th>Date</th>
                      <th>Accessory ID</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                  $data = DBHelper::get("SELECT * FROM `accessories_account` WHERE status = 1 and type = 0 and sellID = {$id}");
                  if ($data->num_rows > 0) {
                      while ($row = $data->fetch_assoc()) {
                        ?>
                          <tr>
                          <td><?php echo $row["amount"];?></td>
                          <td><?php echo date("d-m-Y",strtotime($row["date"]));?></td>
                          <td><?php echo $row["accessID"];?></td>
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
    $name = $_POST["name"];
    $cnic= $_POST["cnic"];
    $mobile = $_POST["mobile"];
    $address = $_POST["address"];
    $salary = $_POST["salary"];
    $id = $investor["id"];
    $password = Encryption::Encrypt($_POST["password"]);
    if(DBHelper::set("UPDATE `shopkeeper` SET pass = '{$password}',  salary={$salary},`name`='{$name}',`cnic`='{$cnic}',`mobile`='{$mobile}',`address`='{$address}' WHERE id =$id ")){
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