<?php include("include/header.php");
$ID = DBHelper::escape($_GET["ID"]);
$app = DBHelper::get("select * from application where id = {$ID}")->fetch_assoc();
$customer = DBHelper::get("select * from customer where id = {$app["cusID"]}")->fetch_assoc();

?>

<style>
@media print{
   .noprint{
       display:none;
       visibility: hidden;
   }

   .sign{
  display: block;
  visibility: visible;
}

   .spg{
     padding: 0px;
     margin: 0px;
   }

   @page { margin: 0; } 
   body { margin: 1.6cm; }

   .ths {
    padding: 8px 10px;
  font-weight: bold;
  font-size: 16px;
  border: 1px #707070 solid;
}
.tds {
  padding: 8px 10px;
  font-size: 16px;
  border: 1px #707070 solid;
}

.pd{
  padding-right: 15px;
}

}
</style>

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
            <h1>Installment History</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-body">


        <div>
             <img  class="rounded img-thumbnail" width="80" height="80" src="../images/logo.png" alt="">
             <h1 style="display:inline-block; margin-left:20px; color:brown; font-size:30px">DBS Installment</h1>
             <?php
            $barcodeText = DBHelper::intCodeRandom(15);
            $barcodeType= 'codabar';
            $barcodeDisplay= 'horizontal';
            $barcodeSize= '20';
            $printText= 'true';
            if($barcodeText != '') {
                echo '<img class="barcode" style="float:right" alt="'.$barcodeText.'" src="include/barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>';
            }
            ?>
            </div>
         <hr>


         <h4 class="mt-3">Customer Information</h4>
         <div class="container mt-3">
             <div class="row">
                 <p class="col"><b>ID: </b><span style="margin-left: 10px;"><?php echo $customer["id"];?></span></p>
                 <p class="col"><b>Name: </b><span style="margin-left: 10px;"><?php echo $customer["name"];?></span></p>
                 <p class="col"><b>F-Name: </b><span style="margin-left: 10px;"><?php echo $customer["fname"];?></span></p>
                 <p class="col"><b>Mobile: </b><span style="margin-left: 10px;"><?php echo $customer["mobile"];?></span></p>
             </div>
         </div>


         <h4 class="mt-4">Application Information</h4>
         <div class="container mt-3">
             <div class="row">
                 <p class="col"><b>ID: </b><span style="margin-left: 10px;"><?php echo $app["id"];?></span></p>
                 <p class="col"><b>Total Price: </b><span style="margin-left: 10px;"><?php echo $app["total_price"];?></span></p>
                 <p class="col"><b>Installment Months: </b><span style="margin-left: 10px;"><?php echo $app["installment_months"];?></span></p>
                 <p class="col"><b>Monthly Payment: </b><span style="margin-left: 10px;"><?php echo $app["monthly_payment"];?></span></p>
                 <p class="col"><b>Advance Payment: </b><span style="margin-left: 10px;"><?php echo $app["advance_payment"];?></span></p>
             </div>
         </div>

         <?php
        $installment = DBHelper::get("SELECT  (
          SELECT COUNT(id)
          FROM   application_installment WHERE appID = {$app["id"]}
      ) AS count,
      (
          SELECT sum(amount)
          FROM   application_installment WHERE appID = {$app["id"]}
      ) AS total")->fetch_assoc();
        ?>

         <h4 class="mt-3">Payment Information</h4>
         <div class="container mt-3">
             <div class="row">
                 <p class="col"><b>Total Paid Amount: </b><span style="margin-left: 10px;"><?php echo $installment["total"];?></span></p>
                 <p class="col"><b>Remaining Amount: </b><span style="margin-left: 10px;"><?php echo ceil($app["total_price"] - $installment["total"]);?></span></p>
                 <p class="col"><b>No of installment: </b><span style="margin-left: 10px;"><?php echo $installment["count"];?></span></p>
             </div>
         </div>

         <h4 class="mt-3">Installment History</h4>
         <table class="table table-striped mt-3 mb-3">
                  <thead>
                    <tr>
                      <th style="width: 10px">ID</th>
                      <th>Amount</th>
                      <th>Date</th>
                      <th>Type</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                  $data = DBHelper::get("SELECT * FROM `application_installment` WHERE appID = {$app["id"]}");
                  if ($data->num_rows > 0) {
                      while ($row = $data->fetch_assoc()) {
                       
                        ?>
                          <tr>
                          <td><?php echo $row["id"];?></td>
                          <td><?php echo $row["amount"];?></td>
                          <td><?php echo $row["date"];?></td>
                          <td><span class="badge <?php echo ($row["type"] == 'A') ? "bg-success":"bg-warning";?>">
                          <?php echo ($row["type"] == 'A') ? "Advance payment":"Monthly payment";?></span></td>
                        </tr>
                        <?php
                      }
                  }
                  ?>

                  </tbody>
                </table>


                <div class="mt-3 noprint">
                <button onclick="Print_rep()" class="btn btn-info">Print</button>
                <button onclick="Redirect()" class="btn btn-success ml-2">Home</button>
                </div>
            

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

<script>
    function Redirect(){
        location.replace("View_Application?ID="+"<?php echo $app["id"];?>");
    }

    function Print_rep(){
        window.print();
    }
</script>
