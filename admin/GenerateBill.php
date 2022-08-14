<?php include("include/header.php") ;?>

<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <!-- Navbar -->
  <?php include("include/nav.php");?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include("include/slide.php");
  $stock = "null";
  if(isset($_POST["submit"]) && isset($_POST["id"])){
    $qry="";
    $id=$_POST["id"];
    $qry="SELECT dbs_shop_stock.*,name as 'comp' FROM dbs_shop_stock INNER JOIN mobile_company_dbs ON companyID = mobile_company_dbs.id where dbs_shop_stock.id = {$id}";
    $stock=DBHelper::get($qry);
  }
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-8 bg-info pt-1 pb-1 text-center" style="border-top-right-radius: 500px; border-bottom-right-radius: 500px;">
            <h1>Generate Bill</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-body">

        <form method="post">
        <h5 class="mb-3">Search mobile in stock by id</h5>
        <div class="form-row">
            <div class="col">
            <input name="id" required type="number" class="form-control" placeholder="Enter stock id....">
            </div>
            <div class="col">
            <button name="submit" class="btn btn-outline-info">Search</button>
            </div>
        </div>
        </form>

        <?php
        if ($stock != "null") {
            if ($stock->num_rows > 0) {
                $stock = $stock->fetch_assoc();
             
             ?>

            <div class="card mt-5">
            <div class="card-body">
             <div class="container">

                 <div class="row">
                     
                        <p class="col"><b>ID: </b> <span class="ml-5"><?php echo $stock["id"];?></span></p>
                        <p class="col"><b>Ram: </b> <span class="ml-5"><?php echo $stock["ram"];?>GB</span></p>
                        <p class="col"><b>Memory: </b> <span class="ml-5"><?php echo $stock["memory"];?>GB</span></p>
                    
                 </div>

                 <div class="row">
                     
                 <p class="col"><b>Quantity: </b> <span class="ml-5"><?php echo $stock["quantity"];?></span></p>
                     <p class="col"><b>Sim: </b> <span class="ml-5"><?php echo $stock["sim"];?></span></p>
                     <p class="col"><b>Network: </b> <span class="ml-5"><?php echo $stock["network"];?></span></p>
                 
              </div>

              <div class="row">
                     
                     <p class="col"><b>Fringerprint: </b> <span class="ml-5"><?php echo ($stock["fringerprint"] == 0)?"Yes":"NO";?></span></p>
                     <p class="col"><b>Front Camera: </b> <span class="ml-5"><?php echo $stock["font_camera"];?>MP</span></p>
                     <p class="col"><b>Company: </b> <span class="ml-5"><?php echo ucwords($stock["comp"]);?></span></p>
                 
              </div>

              <div class="row">
                     
                     <p class="col"><b>Back Camera: </b> <span class="ml-5"><?php echo $stock["back_camera"];?>MP</span></p>
                     <p class="col"><b>Buying Price: </b> <span class="ml-5"><?php echo $stock["buy_price"];?></span></p>
                     <p class="col"><b>Selling Price: </b> <span class="ml-5"><?php echo $stock["selling_price"];?></span></p>
                 
              </div>

             </div>
            </div>
            </div>

             <form class="mt-5" method="post">
                <div class="form-row">
                    <input name="stockID" type="hidden" value="<?php echo $stock["id"];?>">
                    <div class="col">
                    <label for="">Customer name</label>
                    <input name="name" required type="text" class="form-control" placeholder="Customer name">
                    </div>
                    <div class="col">
                    <label for="">Customer Mobile</label>
                    <input name="mobile" required type="number" class="form-control" placeholder="Enter customer mobile number....">
                    </div>
                   
                </div>

                <button name="submit" class="btn btn-outline-info mt-3">Generate Request</button>

                </form>
            <?php
            }
        }
        ?>
       

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
if(isset($_POST["stockID"]) && isset($_POST["name"]) && isset($_POST["mobile"])){
 $stockID = $_POST["stockID"];
 $name = $_POST["name"];
 $mobile = $_POST["mobile"];
 $date = date("Y-m-d");
 if(DBHelper::set("INSERT INTO `db_shop_buy_request`(`cus_name`, `date`, `cus_mobile`, `stockID`) VALUES ('{$name}','{$date}','{$mobile}',{$stockID})")){
  showMessage("Request generated successfully",true);
 }
 else{
     showMessage("Something went wrong try again",false);
 }
}
?>
