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
    $qry="select * from accessories where id = {$id} and quantity > 0";
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
            <h1>Generate sell bill</h1>
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
        <h5 class="mb-3">Search accessories in stock by id</h5>
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
                        <p class="col"><b>Name: </b> <span class="ml-5"><?php echo $stock["name"];?></span></p>
                        <p class="col"><b>Buying Price: </b> <span class="ml-5"><?php echo $stock["buying"];?></span></p>
                    
                 </div>

                 <div class="row">
                     
                 <p class="col"><b>Selling Price: </b> <span class="ml-5"><?php echo $stock["selling"];?></span></p>
                     <p class="col"><b>Stock Quantity: </b> <span class="ml-5"><?php echo $stock["quantity"];?></span></p>
                   
              </div>

             </div>
            </div>
            </div>

             <form class="mt-5" method="post">
                <div class="form-row">
                    <input name="stockID" type="hidden" value="<?php echo $stock["id"];?>">
                    <div class="col">
                    <label for="">Selling Price</label>
                    <input name="price" required type="number" class="form-control" value="<?php echo $stock["selling"]; ?>">
                    </div>
                </div>

                <button name="generatebill" class="btn btn-warning mt-3">Submit</button>

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
if(isset($_POST["generatebill"]) && isset($_POST["price"])){

 $stockID = $_POST["stockID"];
 $date = date("Y-m-d");
 $price = $_POST["price"];
 $prod = DBHelper::get("SELECT * FROM `accessories` WHERE id = {$stockID}")->fetch_assoc();
 $sellID = $_SESSION["isAdmin"];

 if($_SESSION["type"] == "3"){
   // Shopkeeper

   if(DBHelper::set("UPDATE accessories set quantity = quantity - 1  where id = {$stockID}")){
    DBHelper::set("INSERT INTO `accessories_account`(`amount`, `date`, `accessID`, `status`, `sellID`, `type`) VALUES ({$price},'{$date}',{$stockID},0,{$sellID},0)");
    DBHelper::set("INSERT INTO `accessories_transaction`(`date`, `sell_price`, `buy_price`, `accessID`, `quantity`) VALUES ('{$date}',{$price},{$prod["buying"]},{$stockID},1)");
    showMessage("Action perform successfull",true);
   }
   else{
       showMessage("Something went wrong try again",false);
   }

 }
 elseif($_SESSION["type"] == "2"){
  // sub admin
  if(DBHelper::set("UPDATE accessories set quantity = quantity - 1  where id = {$stockID}")){
    DBHelper::set("INSERT INTO `accessories_account`(`amount`, `date`, `accessID`, `status`, `sellID`, `type`) VALUES ({$price},'{$date}',{$stockID},0,{$sellID},1)");
    DBHelper::set("INSERT INTO `accessories_transaction`(`date`, `sell_price`, `buy_price`, `accessID`, `quantity`) VALUES ('{$date}',{$price},{$prod["buying"]},{$stockID},1)");
    showMessage("Action perform successfull",true);
   }
   else{
       showMessage("Something went wrong try again",false);
   }

 }
 else{
   // super admin
   if(DBHelper::set("UPDATE accessories set quantity = quantity - 1  where id = {$stockID}")){
    DBHelper::set("UPDATE dbs_shop_account set balance=balance + {$price} where status = 0");
    DBHelper::set("UPDATE dbs_shop_account set balance=balance - {$prod["buying"]} where status = 1");
    DBHelper::set("INSERT INTO `accessories_transaction`(`date`, `sell_price`, `buy_price`, `accessID`, `quantity`) VALUES ('{$date}',{$price},{$prod["buying"]},{$stockID},1)");
    showMessage("Action perform successfull",true);
   }
   else{
       showMessage("Something went wrong try again",false);
   }
 }
}
?>
