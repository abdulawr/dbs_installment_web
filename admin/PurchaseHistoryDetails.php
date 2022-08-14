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
  $request = DBHelper::get("select * from db_shop_buy_request where id = {$_GET["ID"]}")->fetch_assoc();
  $stock = DBHelper::get("SELECT dbs_shop_stock.*,name as 'comp' FROM dbs_shop_stock INNER JOIN mobile_company_dbs ON companyID = mobile_company_dbs.id where dbs_shop_stock.id = {$request["stockID"]}")->fetch_assoc();
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-8 bg-info pt-1 pb-1 text-center" style="border-top-right-radius: 500px; border-bottom-right-radius: 500px;">
            <h1>Order details</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-body">

        <div class="card">
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

              <div class="row">
                     
                     <p class="col"><b>Name: </b> <span class="ml-5"><?php echo $request["cus_name"];?>MP</span></p>
                     <p class="col"><b>Mobile No: </b> <span class="ml-5"><?php echo $request["cus_mobile"];?></span></p>
                     <p class="col"><b>Date: </b> <span class="ml-5"><?php echo date("d-m-Y",strtotime($request["date"]));?></span></p>
                 
              </div>

             </div>
            
            </div>
            </div>

                    <form method="post" action="GenerateInvoice">
                    <div class="row">
                        <input type="hidden" name="bug_request_id" value="<?php echo $_GET["ID"];?>">
                        <div class="col">
                        <label for="">Selling Price</label>
                        <input name="price" disabled required type="text" class="form-control" placeholder="Enter selling price...." value="<?php echo $stock["selling_price"];?>">
                        </div>
                    </div>
                  
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
