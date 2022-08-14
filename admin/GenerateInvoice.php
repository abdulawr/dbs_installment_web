<?php include("include/header.php") ;?>

<style>
    .ths {
  padding: 10px 15px;
  font-weight: bold;
  font-size: 18px;
  border: 1px #707070 solid;
}
.ptag{
  margin-bottom: 0px;
  padding-bottom: 0px;
}
.tds {
  padding: 10px 15px;
  font-size: 18px;
  border: 1px #707070 solid;
}

.sign{
  display: none;
  visibility: hidden;
}

h3{
  text-align: left !important;
  padding-left: 20px !important;
}


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
  padding: 10px 15px;
  font-weight: bold;
  font-size: 18px;
  border: 1px #707070 solid;
}
.tds {
  padding: 10px 15px;
  font-size: 18px;
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
  <?php include("include/nav.php");
   if(isset($_POST["price"]) && isset($_POST["bug_request_id"])){
    $comp=DBHelper::get("SELECT * FROM `company_info`")->fetch_assoc();
    $price = $_POST["price"];
    $request = DBHelper::get("SELECT * FROM `db_shop_buy_request` WHERE id = {$_POST["bug_request_id"]}")->fetch_assoc();
    $stock = DBHelper::get("SELECT dbs_shop_stock.*,name as 'comp' FROM dbs_shop_stock INNER JOIN mobile_company_dbs ON companyID = mobile_company_dbs.id where dbs_shop_stock.id = {$request["stockID"]}")->fetch_assoc();
  
    $adminID = $_SESSION["isAdmin"];
    $adminType = $_SESSION["type"];
    $date = date("Y-m-d");

    $check_admin_account = DBHelper::get("SELECT id FROM `admin_account` WHERE adminID = {$adminID}");
    if($check_admin_account->num_rows <= 0){
    DBHelper::set("INSERT INTO `admin_account`(`amount`, `adminID`) VALUES (0,{$adminID})");
    }

    if(DBHelper::set("UPDATE dbs_shop_stock SET `quantity` = `quantity` - 1 where id = {$stock["id"]}")){
        if($adminType == 2){
            DBHelper::set("UPDATE admin_account set amount = amount + {$price} WHERE adminID = {$adminID}");
        } 
          else{
            DBHelper::set("UPDATE dbs_shop_account set balance=balance + {$price} where status = 0");
        }
        
        DBHelper::set("UPDATE db_shop_buy_request set sell_price = {$price} WHERE id = {$request["id"]}");
        DBHelper::set("INSERT INTO `admin_transaction`(`amount`, `date`, `status`, `type`, `adminID`) VALUES ($price,'{$date}',4,'dbs_shop',$adminID)");
        DBHelper::set("UPDATE dbs_shop_account set balance=balance - {$stock["buy_price"]} where status = 1");
        DBHelper::set("UPDATE db_shop_buy_request set status = 1 WHERE id = {$request["id"]}");
    }
    else{
        ?>
        <script>
            alert("Invalid access try again");
            location.replace("PendingRequest");
        </script>
        <?php
    }

  }
   else{
       ?>
       <script>
           alert("Invalid access try again");
           location.replace("PendingRequest");
       </script>
       <?php
   }
  ?>
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
            <h1>Invoice</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card backimgs" >
        <div class="card-body">

        <div class="sign container">
          <div class="row">
            <div class="col"> <img  class="rounded img-thumbnail" width="80" height="80" src="../images/logo.png" alt="">
             <h1 style="display:inline-block; margin-left:20px; color:brown; font-size:30px">DBS Installment</h1></div>
           
             <div class="col">
               <div class="row">
                 <div class="col">
                 <p class="ptag">
                <i class="fas fa-phone nav-icon"></i>
                <?php echo $comp["mobile"];?>
                </p>
                <p class="ptag">
                <i class="fas fa-envelope nav-icon"></i>
                <?php echo $comp["email"];?>
                </p>
                 </div>
                 <div class="col">
                 <p class="ptag">
                <i class="fas fa-laptop nav-icon"></i>
                <?php echo $comp["facebook"];?>
                </p>
                <p class="ptag">
                <i class="fas fa-sms nav-icon"></i>
                <?php echo $comp["whatsapp"];?>
                </p>
                 </div>
               </div>
               <p class="ptag urdu" style="color:brown;"><?php echo $comp["address"];?></p>
             </div>
         
            </div>
            <hr>
        </div>


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

     

            <table class="mt-4" style="width: 100%;  border-collapse: collapse;">
            <tr>
             <th class="ths">Customer Name</th>
            <th class="ths">Customer Mobile</th>
            <th class="ths">Total Price</th>
            <th class="ths">Date</th>
            </tr>

            <tr>
                <td class="tds"><?php echo $request["cus_name"];?></td>
                <td class="tds"><?php echo $request["cus_mobile"];?></td>
                <td class="tds"><?php echo $_POST["price"];?></td>
                <td class="tds"><?php echo date('d-m-Y',strtotime($request["date"]));?></td>
              
            </tr>

            </table>

        <br>

        
        <table class="mt-4" style="width: 100%;  border-collapse: collapse;">

            <tr>
             <th class="ths">Ram</th>
             <td class="tds"><?php echo $stock["ram"];?>GB</td>
            </tr>

            <tr>
             <th class="ths">Memory</th>
             <td class="tds"><?php echo $stock["memory"];?>GB</td>
            </tr>

            <tr>
             <th class="ths">Company</th>
             <td class="tds"><?php echo ucwords($stock["comp"]);?></td>
            </tr>

            <tr>
             <th class="ths">SIM</th>
             <td class="tds"><?php echo $stock["sim"];?></td>
            </tr>

            <tr>
             <th class="ths">Network</th>
             <td class="tds"><?php echo $stock["network"];?></td>
            </tr>

            <tr>
             <th class="ths">Front Camera</th>
             <td class="tds"><?php echo $stock["font_camera"];?>MP</td>
            </tr>

            <tr>
             <th class="ths">Back Camera</th>
             <td class="tds"><?php echo $stock["back_camera"];?>MP</td>
            </tr>

        </table>

         
        <div class="mt-5">
            <button onclick="window.print()" class="btn btn-info noprint">Print</button>
            <button onclick="Direct()" class="btn btn-primary noprint">Home</button>
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
    function Direct(){
        location.replace("dashboard");
    }
</script>
