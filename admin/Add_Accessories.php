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
        <div class="col-sm-8 bg-info pt-1 pb-1 text-center" style="border-top-right-radius: 500px; border-bottom-right-radius: 500px;">
            <h1>Add acessories</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content ">

      <!-- Default box -->
      <div class="card">
        <div class="card-body border-bottom-0 border-info">

        <h5 id="stockID" style="display: none;" class="mb-4 bg-primary pl-4 rounded pt-1 pb-1">Plase ksdf</h5>

        <form method="post">

            <div class="form-row">
               <div class="form-group col">
                <label for="inputAddress">Accessories name</label>
                <input name="name" required type="text" class="form-control"  placeholder="accessories name">
                </div>

            </div>



            <div class="form-row">

                <div class="form-group col">
                <label for="inputAddress">Buying price</label>
                <input type="number" required name="buying_price" class="form-control" id="inputAddress" placeholder="Buying price">
                </div>

                <div class="form-group col">
                <label for="inputAddress">Selling price</label>
                <input type="number" required name="selling_price" class="form-control" id="inputAddress" placeholder="Selling price">
                </div>
               
            </div>


            <div class="form-row">

            <div class="form-group col">
            <label for="inputAddress">Quantity</label>
            <input name="quantity" required type="number" class="form-control" id="inputAddress" placeholder="Quantity.....">
            </div>

            </div>


            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
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
if(isset($_POST["submit"]) && isset($_POST["quantity"]) && isset($_POST["name"])){

    $name = $_POST["name"];
    $buying_price = $_POST["buying_price"];
    $selling_price = $_POST["selling_price"];
    $quantity = $_POST["quantity"];
  
    $date = date("Y-m-d");

    $qry = "INSERT INTO `accessories`(`name`, `selling`, `buying`, `quantity`) VALUES ('{$name}',$selling_price,$buying_price,$quantity)";
   
    if(DBHelper::set($qry)){
      $id = $con->insert_id;
      $total = ceil($buying_price * $quantity);
      if(DBHelper::set("UPDATE dbs_shop_account SET balance = balance + {$total} WHERE status = 1 and id = 2")){
       showMessage("Stock item successfully, Please add this stock id to every box or mobile in this stock = $id",true);
       ?>
        <script>
          var id="<?php echo $id;?>";
          $("#stockID").show();
          $("#stockID").text("Please add this stock id to every box or mobile in this stock = "+id);
        </script>
       <?php
      }
      else{
        DBHelper::get("delete from dbs_shop_stock where id = {$id}");
        showMessage("Something went wrong try again, adding stock value",false);
      }
    }
    else{
      showMessage("Something went wrong try again",false);
    }

}
?>
