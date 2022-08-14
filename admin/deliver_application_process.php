<style>
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

@media print{
   .noprint{
       display:none;
       visibility: hidden;
   }

   @page { margin: 0; } 
   body { margin: 1.6cm; }
}

</style>
<?php include("include/header.php") ;?>

<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <!-- Navbar -->
  <?php include("include/nav.php");
   if(isset($_POST["submit"])){
       $invesID = $_POST["investID"];
       $appID = $_POST["appID"];
       $app = DBHelper::get("SELECT companies.name as 'comp',item_type.name as 'item',application.* from application INNER JOIN companies on companies.id = companyID INNER JOIN item_type on item_type.id = item_type_id WHERE application.id = {$appID}")->fetch_assoc();
       $customer = DBHelper::get("SELECT * FROM `customer` WHERE id = {$app["cusID"]}")->fetch_assoc();
       $investor = DBHelper::get("SELECT * FROM `investor` WHERE id = {$invesID}")->fetch_assoc();
  
       $profit = ($app["product_orginal_price"] / 100) * $app["percentage_on_prod"];
       $profit = ceil($profit);
       
       $admin_prof = ceil(($profit / 100) * 25);
       $investor_prof = $profit - $admin_prof;
       $date = date("Y-m-d");
       $investor_total = $app["product_orginal_price"] + $investor_prof;
    
       $pending_payment_query = "INSERT INTO `application_investor_pending_payment`
       (`invest_amount`, `appID`, `investorID`, `cusID`, `date`,`profit`, `total_amount`,payable)
       VALUES ({$app["product_orginal_price"]},
              {$appID},
              {$invesID},
              {$app["cusID"]},
              '{$date}',
              {$investor_prof},
              {$investor_total}, {$investor_total});";
$state = false;
if(DBHelper::set($pending_payment_query)){
  $insert_id = $con->insert_id;
  $file = $_FILES["file"];
  $typ = strtolower(explode("/",$file["type"])[1]);
  $fileName = "app_".$appID."_".RandomString(30).".".$typ;
  move_uploaded_file($file["tmp_name"],"../images/application/".$fileName);
  if(DBHelper::set("UPDATE application set status = 3,investorID=$invesID, delivery_image='{$fileName}' WHERE id = {$appID}")){
    if(DBHelper::set("INSERT INTO `application_installment`(`appID`, `date`, `amount`, `type`) VALUES ({$appID},'{$date}',{$app["advance_payment"]},'A')")){
    $installment_id = $con->insert_id;
    
    if(DBHelper::set("UPDATE investor_account SET balance = balance - {$app["product_orginal_price"]} where investorID = {$invesID}")){
      $adminID = $_SESSION["isAdmin"];
      $adminType = $_SESSION["type"];
      $check_admin_account = DBHelper::get("SELECT id FROM `admin_account` WHERE adminID = {$adminID}");
      if($check_admin_account->num_rows <= 0){
       DBHelper::set("INSERT INTO `admin_account`(`amount`, `adminID`) VALUES (0,{$adminID})");
      }

      if($adminType == 2){
        DBHelper::set("UPDATE admin_account set amount = amount + {$app["advance_payment"]} WHERE adminID = {$adminID}");
      }
      else{
        DBHelper::set("UPDATE company_account set amount=amount+ {$app["advance_payment"]}");
      }

      DBHelper::set("INSERT INTO `admin_transaction`(`amount`, `date`, `status`, `type`, `adminID`,appID) VALUES ({$app["advance_payment"]},'{$date}',2,'customer',$adminID,$appID)");

      $state = true;
    }
    else{
      $state = false;
      DBHelper::set("DELETE FROM `application_investor_pending_payment` WHERE id = {$insert_id}");
      unlink("../images/application/".$fileName);
      DBHelper::set("DELETE FROM `application_installment` WHERE id = {$installment_id}");
      DBHelper::set("UPDATE application set status = 1 WHERE id = {$appID}");
      ?>
      <script>
        var id="<?php echo $appID; ?>"
        alert("Something went in changing application status");
        location.replace("deliver_application?ID="+id);
      </script>
      <?php
    }
     
   }
   else{
    $state = false;
    DBHelper::set("DELETE FROM `application_investor_pending_payment` WHERE id = {$insert_id}");
    unlink("../images/application/".$fileName);
    DBHelper::set("UPDATE application set status = 1 WHERE id = {$appID}");
    ?>
    <script>
      var id="<?php echo $appID; ?>"
      alert("Something went in changing application status");
      location.replace("deliver_application?ID="+id);
    </script>
    <?php
   }
  }
  else{
    $state = false;
    DBHelper::set("DELETE FROM `application_investor_pending_payment` WHERE id = {$insert_id}");
    unlink("../images/application/".$fileName);
   ?>
   <script>
     
     var id="<?php echo $appID; ?>"
     alert("Cannot perform the action righ now try again later or contact the developer");
     location.replace("deliver_application?ID="+id);
   </script>
   <?php
  }

 }
 else{
  $state = false;
  ?>
  <script>
    var id="<?php echo $appID; ?>"
    alert("Something went wrong try again");
    location.replace("deliver_application?ID="+id);
  </script>
  <?php
 }

   }
   else{
    $state = false;
    ?>
    <script>
      var id="<?php echo $appID; ?>"
      alert("Invalid data is provided");
      location.replace("deliver_application?ID="+id);
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
         <br>
         <h3>Customer Information</h3>
         <br>

         <table class="urdu" style="width: 100%;  border-collapse: collapse;">
            <tr>
            <th class="ths">نام</th>
            <th class="ths">موبائل نمبر</th>
            <th class="ths">قومی شناختی کارڈ</th>
            <th class="ths">مکمل پتہ</th>
            </tr>

            <tr>
                <td class="tds"><?php echo $customer["name"];?></td>
                <td class="tds"><?php echo $customer["mobile"];?></td>
                <td class="tds"><?php echo $customer["cnic"];?></td>
                <td class="tds"><?php echo $customer["address"];?></td>
            </tr>

            </table>
            <hr>

         <br>
         <h3>Application Information</h3>
         <br>

         <table  style="width: 100%;  border-collapse: collapse;" class="border-danger-1">
            <tr>
            <th class="ths">Application ID</th>
            <th class="ths">Item</th>
            <th class="ths">Company</th>
            <th class="ths">Adance payment</th>
            <th class="ths">Monthly payment</th>
            <th class="ths">Installment months</th>
            <th class="ths">Total price</th>
            </tr>

            <tr>
                <td class="tds"><?php echo $app["id"];?></td>
                <td class="tds"><?php echo $app["product_name"];?></td>
                <td class="tds"><?php echo $app["comp"];?></td>
                <td class="tds"><?php echo $app["advance_payment"];?></td>
                <td class="tds"><?php echo $app["monthly_payment"];?></td>
                <td class="tds"><?php echo $app["installment_months"];?></td>
                <td class="tds"><?php echo $app["total_price"];?></td>
            </tr>

            </table>
            <hr>

            <button onclick="prints()" class="noprint btn btn-primary">Print</button>
            <a href="Application" class="btn btn-info ml-2 noprint">Home</a>

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
 function prints(){
      window.print();
    }
</script>

<?php
if($state){
  showMessage("Operation perform successfull",true);
}
?>

