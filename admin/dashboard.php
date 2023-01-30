<?php include("include/header.php") ;?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <?php include("include/nav.php");?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include("include/slide.php");
  $app = DBHelper::get("SELECT  (
    SELECT COUNT(id) from application WHERE status = 0 and company_id = '{$_SESSION["company_id"]}'
) AS pending,
(
    SELECT COUNT(id) from application WHERE status = 1 and company_id = '{$_SESSION["company_id"]}'
) AS accepted,
(
   SELECT COUNT(id) from application WHERE status = 3 and company_id = '{$_SESSION["company_id"]}'
) AS active,
(
   SELECT COUNT(id) from application where company_id = '{$_SESSION["company_id"]}'
) AS app,
(
  SELECT COUNT(id) from application WHERE status = 4 and company_id = '{$_SESSION["company_id"]}'
) AS complete")->fetch_assoc();


function get_months_between_dates(string $start_date, string $end_date): ?int
{
    $startDate = $start_date instanceof Datetime ? $start_date : new DateTime($start_date);
    $endDate = $end_date instanceof Datetime ? $end_date : new DateTime($end_date);
    $interval = $startDate->diff($endDate);
    $months = ($interval->y * 12) + $interval->m;
    
  return $startDate > $endDate ? -$months : $months;
    
}

               $active_app = DBHelper::get("select * from application where status = 3 and company_id = '{$_SESSION["company_id"]}'");
               $cnnsss = 0;
                  while($row = $active_app->fetch_assoc()){
                   
                    $activeDate = $row["active_date"];
                    $currentDate = date("Y-m-d");
                    if (!empty($activeDate) && $activeDate != "null") {
                        $cnt =  get_months_between_dates($activeDate, $currentDate)."<br>";
                        $counts = DBHelper::get("SELECT COUNT(id) as cc FROM `application_installment` WHERE `appID` = {$row["id"]} and type = 'I' limit 1")->fetch_assoc()["cc"];
                  
                        if ($counts < $cnt) {
                            $cnnsss++;
                        }
                    }
                    
                  }


$data = DBHelper::get("SELECT  (
  SELECT COUNT(id) from customer where company_id = '{$_SESSION["company_id"]}'
) AS customer,
(
  SELECT COUNT(id) from investor where company_id = '{$_SESSION["company_id"]}'
) AS investor,
(
 SELECT COUNT(id) from admin where type = 1
) AS super,
(
SELECT COUNT(id) from admin where type = 2  and  company_id = '{$_SESSION["company_id"]}'
) AS sub")->fetch_assoc();

    $company = DBHelper::get("SELECT * FROM `company_info` order by id asc");
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <div class="content-header">
      <div class="container-fluid">
       
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="card m-3" style="margin-top:0px !important">
      <div class="card-body">

       <div class="container">

       <?php if($_SESSION["type"] == 1){ ?>
        <div class="row">
          <div class="col-12">
          <div class="form-group">
            <label for="companyDrop">Select Company</label>
            <select class="form-control" id="companyDrop">
              <?php while($row = $company->fetch_assoc()){ ?>
                <option <?php if($row['id'] == $_SESSION["company_id"]){echo "selected";} ?> value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
              <?php } ?>
            </select>
          </div>
          </div>
        </div>
        <?php } ?>

        <div class="row">
          <div class="col-12">
              <h4>
                    <h3 class="bg-success text-center py-1 mb-3 rounded"><?php echo $_SESSION['company']['name'];?></h3>
              </h4>
          </div>
        </div>
        <div class="row">

        <div class="col-4" style="border-right: 1px dotted grey;">
          <!-- <img width="120" height="120" class="img-thumbnail" src="../images/logo.png" alt=""> -->
          <h5 class='bg-info py-1 text-center rounded'>Company Profile</h5>
          <p style="margin-bottom: 0px;"><b>Mobile: </b> <?php echo $_SESSION['company']["mobile"];?></p>
          <p style="margin-bottom: 0px;"><b>Email: </b> <?php echo $_SESSION['company']["email"];?></p>
          <p style="margin-bottom: 0px;"><b>Facebook: </b> <?php echo $_SESSION['company']["facebook"];?></p>
          <p style="margin-bottom: 0px;"><b>What`s app: </b> <?php echo $_SESSION['company']["whatsapp"];?></p>
          <p style="margin-bottom: 0px;"><b>Address: </b> <?php echo $_SESSION['company']["address"];?></p>
        </div>

        <?php
      
        $account = DBHelper::get("SELECT * FROM `company_account` where id = '{$_SESSION["company_id"]}'")->fetch_assoc();
        $pending_account = DBHelper::get("SELECT SUM(amount) as 'sum' from admin_account where company_id = '{$_SESSION["company_id"]}' ");
        $pending_account = ($pending_account->num_rows > 0) ? $pending_account->fetch_assoc()["sum"] : "0";
       ?>
        <div class="col-4" style="border-right: 1px dotted grey;">
         <h5 class='bg-danger py-1 text-center rounded'>Company Account</h5>
         <h5><b>Balance: </b> <?php echo $account["amount"];?></h5>
         <h5><b>Pending Balance: </b> <?php echo $pending_account;?></h5>
        
         <?php
         $pendingPayment = DBHelper::get("SELECT SUM(payable) as tot from application_investor_pending_payment WHERE `payable` > 0 and company_id = '{$_SESSION["company_id"]}';");
         ?>

         <h5><b>Investor Pending: </b> <?php echo $pendingPayment->fetch_assoc()["tot"];?></h5>

         <?php
         $customerPayment = DBHelper::get("SELECT id,`total_price` FROM application WHERE status = 3 and company_id = '{$_SESSION['company_id']}';");
         $totalPPCUS = 0;
          while($row = $customerPayment->fetch_assoc()){
           $pp = DBHelper::get("SELECT SUM(amount) as tot from application_installment WHERE appID = {$row["id"]};");
           if($pp->num_rows > 0){
             $pps = (int) $pp->fetch_assoc()["tot"];
             $totalPPCUS += ceil(abs((int) $row["total_price"] - $pps));
           }
           else{
             $totalPPCUS += (int) $row["total_price"];
           }

          }
         ?>

         <h5><b>Customer Pending: </b> <?php echo $totalPPCUS ;?></h5>

         <?php
         $available = abs($account["amount"] - $totalPPCUS);
         ?>

         <h5><b>Available Balance: </b> <?php echo $available;?></h5>

         <?php if($_SESSION["type"] == '1') {?>
         <a href="AdminList" class="btn btn-outline-info mt-3">View pending payment</a>
         <?php } ?>
         
         <a href="ShotInstallment" class="btn btn-secondary mt-3">View Shot Installments
         <span class="badge badge-light margin-left:10px;"><?php echo $cnnsss; ?></span>
         </a>
        </div>

        

        <?php
        $account = DBHelper::get("SELECT * FROM `dbs_shop_account` WHERE `status` = 0 and company_id = '{$_SESSION["company_id"]}'")->fetch_assoc();
        $stock = DBHelper::get("SELECT * FROM `dbs_shop_account` WHERE `status` = 1 and company_id = '{$_SESSION["company_id"]}'")->fetch_assoc();
        ?>
        <div class="col-4">
        <h5 class='bg-warning py-1 text-center rounded'>Shop Account</h5>
        <h5><b>Balance: </b> <?php echo $account["balance"];?></h5>
        <h5><b>Stock: </b> <?php echo $stock["balance"];?></h5>
        </div>

        </div>
       </div>

      </div>
    </div>


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

      <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <a href="Application?type=pending">
              <span class="info-box-icon bg-info elevation-1 h-100">
                <i class="fas fa-file"></i></span>
              </a>
              <div class="info-box-content">
                <span class="info-box-text">Pending Application</span>
                <span class="info-box-number">
                  <?php echo $app["pending"];?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <a href="Application?type=active">
              <span class="info-box-icon bg-success elevation-1 h-100"><i class="fas fa-cube"></i></span>
              </a>
              <div class="info-box-content">
                <span class="info-box-text">Active Application</span>
                <span class="info-box-number"><?php echo $app["active"];?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <a href="Application?type=completed">
              <span class="info-box-icon bg-warning elevation-1 h-100"><i class="fas fa-cog"></i></span>
              </a>
              <div class="info-box-content">
                <span class="info-box-text">Complete Application</span>
                <span class="info-box-number"><?php echo $app["complete"];?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
            <a  href="Application?type=accepted">
              <span class="info-box-icon bg-secondary elevation-1 h-100"><i class="fas fa-thumbs-up"></i></span>
            </a>
              <div class="info-box-content">
                <span class="info-box-text">Accepted Application</span>
                <span class="info-box-number"><?php echo $app["accepted"];?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

           <!-- /.col -->
           <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <a  href="Application">
              <span class="info-box-icon bg-primary elevation-1 h-100"><i class="fas fa-bars"></i></span>
              </a>
              <div class="info-box-content">
                <span class="info-box-text">Total Application</span>
                <span class="info-box-number"><?php echo $app["app"];?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <a href="Customer_List">
              <span class="info-box-icon bg-info elevation-1 h-100">
                <i class="fas fa-users"></i></span>
              </a>
              <div class="info-box-content">
                <span class="info-box-text">Total Customer</span>
                <span class="info-box-number">
                <?php echo $data["customer"];?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>


            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <a href="InvestorList">
              <span class="info-box-icon bg-success elevation-1 h-100"><i class="fas fa-users"></i></span>
              </a>
              <div class="info-box-content">
                <span class="info-box-text">Total Investor</span>
                <span class="info-box-number"><?php echo $data["investor"];?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <a href="AdminList">
              <span class="info-box-icon bg-warning elevation-1 h-100"><i class="fas fa-cogs"></i></span>
              </a>
              <div class="info-box-content">
                <span class="info-box-text">Super Admin</span>
                <span class="info-box-number"><?php echo $data["super"];?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
            <a  href="AdminList">
              <span class="info-box-icon bg-secondary elevation-1 h-100"><i class="fas fa-cogs"></i></span>
            </a>
              <div class="info-box-content">
                <span class="info-box-text">Sub Admin</span>
                <span class="info-box-number"><?php echo $data["sub"];?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->


        </div>
    
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->


    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Shop Section</h1>
          </div><!-- /.col -->
         
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <?php
  $dbs = DBHelper::get("SELECT  (
      SELECT COUNT(id) from shopkeeper where company_id = '{$_SESSION["company_id"]}'
  ) AS customer,
  (
      SELECT COUNT(id) from db_shop_buy_request WHERE status = 0 and company_id = '{$_SESSION["company_id"]}'
  ) AS pending,
  (
     SELECT COUNT(id) from db_shop_buy_request WHERE status = 1 and company_id = '{$_SESSION["company_id"]}'
  ) AS history,
  (
  SELECT sum(quantity) from dbs_shop_stock where company_id = '{$_SESSION["company_id"]}'
  ) AS stock")->fetch_assoc();
    ?>



 <!-- Main content -->
 <section class="content">
      <div class="container-fluid">

      <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <a href="ShopkeeperList">
              <span class="info-box-icon bg-info elevation-1 h-100">
                <i class="fas fa-user"></i></span>
              </a>
              <div class="info-box-content">
                <span class="info-box-text">Shop Customer</span>
                <span class="info-box-number">
                <?php echo $dbs["customer"];?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <a href="PendingRequest">
              <span class="info-box-icon bg-success elevation-1 h-100"><i class="fas fa-tasks"></i></span>
              </a>
              <div class="info-box-content">
                <span class="info-box-text">Pending Request</span>
                <span class="info-box-number"><?php echo $dbs["pending"];?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <a href="PurchaseHistory">
              <span class="info-box-icon bg-warning elevation-1 h-100"><i class="fas fa-cart-plus"></i></span>
              </a>
              <div class="info-box-content">
                <span class="info-box-text">Purchase History</span>
                <span class="info-box-number"><?php echo $dbs["history"];?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
            <a  href="StockList">
              <span class="info-box-icon bg-secondary elevation-1 h-100"><i class="fas fa-home"></i></span>
            </a>
              <div class="info-box-content">
                <span class="info-box-text">Total Stock</span>
                <span class="info-box-number"><?php echo $dbs["stock"];?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

        </div>
    
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->


  </div>

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
  $('#companyDrop').on('change', function (e) {
    var company = $('#companyDrop').find(":selected").val();
    location.replace("dashboard?cmp="+company)

});
</script>