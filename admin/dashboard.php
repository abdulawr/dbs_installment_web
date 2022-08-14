<?php include("include/header.php") ;?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <?php include("include/nav.php");?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include("include/slide.php");
  $app = DBHelper::get("SELECT  (
    SELECT COUNT(id) from application WHERE status = 0
) AS pending,
(
    SELECT COUNT(id) from application WHERE status = 1
) AS accepted,
(
   SELECT COUNT(id) from application WHERE status = 3
) AS active,
(
   SELECT COUNT(id) from application
) AS app,
(
  SELECT COUNT(id) from application WHERE status = 4
) AS complete")->fetch_assoc();


function get_months_between_dates(string $start_date, string $end_date): ?int
{
    $startDate = $start_date instanceof Datetime ? $start_date : new DateTime($start_date);
    $endDate = $end_date instanceof Datetime ? $end_date : new DateTime($end_date);
    $interval = $startDate->diff($endDate);
    $months = ($interval->y * 12) + $interval->m;
    
  return $startDate > $endDate ? -$months : $months;
    
}

               $active_app = DBHelper::get("select * from application where status = 3");
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
  SELECT COUNT(id) from customer
) AS customer,
(
  SELECT COUNT(id) from investor
) AS investor,
(
 SELECT COUNT(id) from admin where type = 1
) AS super,
(
SELECT COUNT(id) from admin where type = 2
) AS sub")->fetch_assoc();

$company = DBHelper::get("SELECT * FROM `company_info`")->fetch_assoc();
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <div class="content-header">
      <div class="container-fluid">
       
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="card m-3">
      <div class="card-body">

       <div class="container">
        <div class="row">

        <div class="col-4" style="border-right: 1px dotted grey;">
          <img width="120" height="120" class="img-thumbnail" src="../images/logo.png" alt="">
          <h5><?php echo $company["name"];?></h5>
          <p style="margin-bottom: 0px;"><b>Mobile: </b> <?php echo $company["mobile"];?></p>
          <p style="margin-bottom: 0px;"><b>Email: </b> <?php echo $company["email"];?></p>
          <p style="margin-bottom: 0px;"><b>Facebook: </b> <?php echo $company["facebook"];?></p>
          <p style="margin-bottom: 0px;"><b>What`s app: </b> <?php echo $company["whatsapp"];?></p>
          <p style="margin-bottom: 0px;"><b>Address: </b> <?php echo $company["address"];?></p>
        </div>

        <?php
      
        $account = DBHelper::get("SELECT * FROM `company_account` ")->fetch_assoc();
        $pending_account = DBHelper::get("SELECT SUM(amount) as 'sum' from admin_account")->fetch_assoc();
        ?>
        <div class="col-4" style="border-right: 1px dotted grey;">
         <h4 >DBS Company Account</h4>
         <h5><b>Balance: </b> <?php echo $account["amount"];?></h5>
         <h5><b>Pending Balance: </b> <?php echo $pending_account["sum"];?></h5>
        
         <?php
         $pendingPayment = DBHelper::get("SELECT SUM(payable) as tot from application_investor_pending_payment WHERE `payable` > 0;");
         ?>

         <h5><b>Investor Pending: </b> <?php echo $pendingPayment->fetch_assoc()["tot"];?></h5>

         <?php
         $customerPayment = DBHelper::get("SELECT id,`total_price` FROM application WHERE status = 3;");
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
        $account = DBHelper::get("SELECT * FROM `dbs_shop_account` WHERE `status` = 0")->fetch_assoc();
        $stock = DBHelper::get("SELECT * FROM `dbs_shop_account` WHERE `status` = 1")->fetch_assoc();
        ?>
        <div class="col-4">
        <h4 >DBS Shop Account</h4>
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
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $app["pending"];?></h3>

                <p>Pending Application</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="Application?type=pending" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $app["active"];?></h3>

                <p>Active Application</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="Application?type=active" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $app["complete"];?></h3>

                <p>Complete Application</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="Application?type=completed" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-dark">
              <div class="inner">
                <h3><?php echo $app["accepted"];?></h3>

                <p>Accepted Application</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="Application?type=accepted" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3><?php echo $app["app"];?></h3>

                <p>Total Application</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="Application" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
    
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

<hr>

    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
         
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $data["customer"];?></h3>

                <p>Total Customer</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="Customer_List" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>


          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $data["investor"];?></h3>

                <p>Total Investor</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="InvestorList" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>


          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $data["super"];?></h3>

                <p>Super Admin</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="AdminList" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>


          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $data["sub"];?></h3>

                <p>Sub Admin</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="AdminList" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
         
        </div>
        <!-- /.row -->
        <!-- Main row -->
    
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>




    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">DBS Shop Section</h1>
          </div><!-- /.col -->
         
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <?php
    $dbs = DBHelper::get("SELECT  (
      SELECT COUNT(id) from shopkeeper
  ) AS customer,
  (
      SELECT COUNT(id) from db_shop_buy_request WHERE status = 0
  ) AS pending,
  (
     SELECT COUNT(id) from db_shop_buy_request WHERE status = 1
  ) AS history,
  (
  SELECT sum(quantity) from dbs_shop_stock 
  ) AS stock")->fetch_assoc();
    ?>

    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $dbs["customer"];?></h3>

                <p>DBS Shop Customer</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="ShopkeeperList" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $dbs["pending"];?></h3>

                <p>Pending Request</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="PendingRequest" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $dbs["history"];?></h3>

                <p>Purchase History</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="PurchaseHistory" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3><?php echo $dbs["stock"];?></h3>

                <p>Total Stock</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="StockList" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
    
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>


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
