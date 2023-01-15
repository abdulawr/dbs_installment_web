<?php include("include/header.php");
$id = $_GET["ID"];
$investID = $_GET["investID"];
$details = DBHelper::get("SELECT * FROM `application_investor_pending_payment` WHERE id = {$id} and investorID = {$investID} and company_id = '{$_SESSION["company_id"]}' ")->fetch_assoc();
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
            <h1>Investor application amount</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-body">


          <p style="margin-bottom: 0px;"><b>Invest Amount: </b><?php echo $details["invest_amount"];?></p>
          <p style="margin-bottom: 0px;"><b>Profit Amount: </b><?php echo $details["profit"];?></p>
          <p style="margin-bottom: 0px;"><b>Totoal: </b><?php echo $details["total_amount"];?></p>
          <p style="margin-bottom: 0px;"><b>Paid Amount: </b><?php echo $details["paid"];?></p>
          <p style="margin-bottom: 0px;"><b>Payable Amount: </b><?php echo $details["payable"];?></p>

          <form class="mt-3" method="post">
              <input type="hidden" name="ID" value="<?php echo $details["id"];?>">
              <input type="hidden" name="pay" value="<?php echo $details["payable"];?>">
                <div class="form-group">
                    <label for="exampleInputEmail1">Amount</label>
                    <input required name="amount" type="number" class="form-control" placeholder="Amount">
                </div>
               
                <button name="added_amount" type="submit" class="btn btn-success">Submit</button>
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
if(isset($_POST["ID"]) && isset($_POST["pay"]) && isset($_POST["amount"]) && isset($_POST["added_amount"])){

  $ID = $_POST["ID"];
  $amount = $_POST["amount"];
  $payable = $_POST["pay"];

  if($amount <= $payable){
   if(DBHelper::set("UPDATE application_investor_pending_payment set payable = payable - {$amount}, paid = paid + {$amount} WHERE id = {$ID} and company_id = '{$_SESSION["company_id"]}'"))
   {
    DBHelper::set("UPDATE `investor_account` set `balance`= balance + {$amount} WHERE investorID = {$investID}");
    DBHelper::set("UPDATE company_account set amount = amount - {$amount}");
    ?>
    <script>
        var ID = "<?php echo $investID;?>"
        alert("Amount is added in customer account successfully");
        location.href = "Investor_Profile?ID="+ID;
    </script>
    <?php
  } else{
    showMessage("Something went wrong try again",false);
  } 

}
else{
      showMessage("Amount should not be greater then payable amount",false);
}

}
?>
