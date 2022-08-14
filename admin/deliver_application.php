<?php include("include/header.php") ;
$id = $_GET["ID"];
$app = DBHelper::get("SELECT companies.name as 'comp',item_type.name as 'item',application.* from application INNER JOIN companies on companies.id = companyID INNER JOIN item_type on item_type.id = item_type_id WHERE application.id = {$id}")->fetch_assoc();
$investorList = DBHelper::get("SELECT investor.*,investor_account.balance FROM investor INNER JOIN investor_account on investorID = investor.id WHERE balance >= {$app["product_orginal_price"]};");
?>

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
            <h5>Application Status</h5>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-body">
        <div class="alert alert-warning" role="alert">
         At this stage advance payment should be paid completly (Other wise system will not allow you perform this stage)
        </div>
        <?php
        if ($investorList->num_rows > 0) {
            ?>
        <form enctype="multipart/form-data" action="deliver_application_process.php" method="post">

            <div class="row">
                <div class="col">
                <label for="">Advance payment</label>
                <input disabled required name="advance_payment" type="number" class="form-control" placeholder="Advance payment" value="<?php echo $app["advance_payment"];?>">
                </div>
            </div>


            <div class="form-group mt-3">
                <label for="exampleFormControlSelect1">Select investor</label>
                <select name="investID" class="form-control" id="exampleFormControlSelect1">
                <?php
                while ($row = $investorList->fetch_assoc()) {
                    ?>
                 <option value="<?php echo $row["id"]?>"><?php echo $row["name"];?>   <small style="color:blue !important; ">cnic: <?php echo $row["cnic"];?></small></option>
                <?php
                } ?>
               
                </select>
            </div>

            <div class="form-group">
                <label for="exampleFormControlFile1">Select box image</label>
                <input required name="file" type="file" class="form-control-file" id="exampleFormControlFile1">
            </div>

            <input name="appID" required type="hidden" value="<?php echo $app["id"];?>">

            <button type="submit" name="submit" class="btn btn-outline-info">Deliver It</button>

            </form>
          <?php
        }else{
            ?>
            <h2>No investor exist to match this customer requirements</h2>
            <?php
        }?>
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
