<?php include("include/header.php") ;
$comp= $_SESSION["company"];
$id = DBHelper::escape($_GET["ID"]);
$app = DBHelper::get("SELECT companies.name as 'comp',item_type.name as 'item',application.* from application INNER JOIN companies on companies.id = companyID INNER JOIN item_type on item_type.id = item_type_id WHERE application.id = {$id}")->fetch_assoc();
$customer = DBHelper::get("SELECT * from customer WHERE id = {$app["cusID"]}")->fetch_assoc();
$proof_person = DBHelper::get("SELECT * FROM `application_proof_person` WHERE appID = {$id}");
?>

<style>
    .ths {
  padding: 8px 10px;
  font-weight: bold;
  font-size: 16px;
  border: 1px #707070 solid;
}
.ptag{
  margin-bottom: 0px;
  padding-bottom: 0px;
}
.tds {
  padding: 8px 10px;
  font-size: 16px;
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

<body class="pd hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <!-- Navbar -->
  <?php include("include/nav.php");?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include("include/slide.php");?>
  <?php include("include/image_model.php");?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="spg content">

      <!-- Default box -->
      <div class="spg card">
        <div class="spg card-body">

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

        <div class="sign container">
          <div class="row">
            <div class="col"> <img  class="rounded img-thumbnail" width="80" height="80" src="c_images/<?php echo $_SESSION['company']['logo'];?>" alt="">
             <h1 style="display:inline-block; margin-left:20px; color:brown; font-size:30px"><?php echo $_SESSION["company"]['name'];?></h1>

            </div>
           
            

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
               <p class="ptag " style="color:brown;"><?php echo $comp["address"];?></p>
             </div>
         
            </div>
            <hr>
        </div>


        <?php
          if($app["status"] == 0){
           ?>
            <p class="noprint bg-info w-50 pt-1 pb-1 pl-5 m-0 mb-3 rounded">Application Status ( Pending )</p>
           <?php
          }
          elseif($app["status"] == 1){
            ?>
             <p class="noprint bg-success w-50 pt-1 pb-1 pl-5 m-0 mb-3 rounded">Application Status ( Accepted )</p>
             <?php
             if($app["advance_payment_status"] == '0'){
              $remaing = $app["advance_payment"] - $app["advance_payment_paid"];
              ?>
                <p class="noprint bg-danger  pt-1 pb-1 pl-5 m-0 mb-3 rounded">Advance amount is not paid completly, (Paid Amount = <?php echo " ".$app["advance_payment"];?>) and (Remaining Amount = <?php echo " ".$remaing;?>)</p>
              <?php
             }
             ?>
           
          <?php
          }
          elseif($app["status"] == 2){
            ?>
              <p class="noprint bg-primary w-50 pt-1 pb-1 pl-5 m-0 mb-3 rounded">Application Status ( Delivered )</p>
            <?php 
          }
          elseif($app["status"] == 3){
            ?>
              <p class="noprint bg-orange w-50 pt-1 pb-1 pl-5 m-0 mb-3 rounded text-white">Application Status ( Active )</p>
            <?php  
          }
          elseif($app["status"] == 4){
            ?>
              <p class="noprint bg-warning w-50 pt-1 pb-1 pl-5 m-0 mb-3 rounded">Application Status ( Completed )</p>
           <?php
          }
          elseif($app["status"] == 5){
            ?>
              <p class="noprint bg-danger w-50 pt-1 pb-1 pl-5 m-0 mb-3 rounded">Application Status ( Rejected )</p>
              <p class="noprint bg-warning pt-1 pb-1 pl-5 m-0 mb-3 rounded">Rejection Reasion=> <?php echo $app["rej_des"];?></p>
         <?php
          }
        ?>


      <p class="noprint bg-secondary w-50 pt-1 pb-1 pl-5 m-0 mb-3 rounded">Discount Amount:   ( <?php echo $app["discount_amount"]?> )</p>
           


        <h3 class="bg-success rounde" style="padding: 5px 10px;">
            Customer Details
        </h3>

        <div class="spg jumbotron jumbotron-fluid pl-3" style="padding-top: 10px; padding-bottom:10px">
        <div class="container">
            <div class="row">

            

            <div class="col-8">

            <table class=" mt-4" style="width: 100%;  border-collapse: collapse;">
            <tr>
             <th class="ths">ID</th>
            <th class="ths">Name</th>
            <th class="ths">F-Name</th>
            <th class="ths">Mobile</th>
            <th class="ths">CNIC</th>
            <th class="ths">Address</th>
            </tr>

            <tr>
                <td class="tds"><?php echo $customer["id"];?></td>
                <td class="tds"><?php echo $customer["name"];?></td>
                <td class="tds"><?php echo $customer["fname"];?></td>
                <td class="tds"><?php echo $customer["mobile"];?></td>
                <td class="tds"><?php echo $customer["cnic"];?></td>
                <td class="tds"><?php echo $customer["address"];?></td>
            </tr>

            </table>

            </div>

            <div class="col-4 text-center">
             <img onclick="ShowImage(this.src)" style="width: 250px;" src="../images/customer/<?php echo $customer["image"];?>" alt="">
             </div>
            </div>
        </div>
        </div>

        <div class="jumbotron jumbotron-fluid pl-3 pt-2" style="padding-top: 10px; padding-bottom:10px">
        <div class="container">
            <div class="row">
            <table style="width: 100%;  border-collapse: collapse;">
              <tr>
                <th class="ths">Application Mobile No:</th>
                <?php
             $mob = DBHelper::get("SELECT * FROM `application_mobile_number` WHERE `appID` = {$app["id"]}");
             while($row = $mob->fetch_assoc()){
               ?>
               <td class="tds"><?php echo $row["mobile"];?></td>
               <?php
             }
             ?>
              </tr>
            </table>
            </div>
        </div>
        </div>

        <hr>

        <h3 class="bg-success rounded " style="padding: 5px 10px;">
            Application Details
        </h3>

        <div class="jumbotron jumbotron-fluid pr-3" style="padding-top: 10px; padding-bottom:10px">
        <div class="container">
          <div class="row">

          <div class="col">

          <table class="" style="width: 100%;  border-collapse: collapse;">

          <tr>
            <th class="ths">Application ID</th>
            <td class="tds"><?php echo $app["id"];?></td>
          </tr>

          <tr>
            <th class="ths">Customer Age</th>
            <td class="tds"><?php echo $app["age"];?></td>
          </tr>

          <tr>
            <th class="ths">Monthly Income</th>
            <td class="tds"><?php echo $app["monthly_income"];?></td>
          </tr>

          <tr>
            <th class="ths">Business Type</th>
            <td class="tds"><?php echo $app["business_type"];?></td>
          </tr>

          <tr>
            <th class="ths">Business Address</th>
            <td class="tds"><?php echo $app["business_address"];?></td>
          </tr>

          <tr>
            <th class="ths">Application Date</th>
            <td class="tds"><?php echo $app["date"];?></td>
          </tr>

          <tr>
            <th class="ths">Model</th>
            <td class="tds"><?php echo $app["model_no"];?></td>
          </tr>

          <tr>
            <th class="ths">Company Name</th>
            <td class="tds"><?php echo ucfirst($app["comp"]);?></td>
          </tr>

          <tr>
            <th class="ths">Item Name</th>
            <td class="tds"><?php echo $app["product_name"];?></td>
          </tr>

          </table>

          </div>

             <div class="col">

            <table class="" style="width: 100%;  border-collapse: collapse;">
            
            <tr>
               <th class="ths">Item Type</th>
               <td class="tds"><?php echo ucfirst($app["item"]);?></td>
             </tr>

             <tr>
              <th class="ths">Item Orginal Price</th>
               <td class="tds"><?php echo $app["product_orginal_price"];?></td>
             </tr>

             <tr>
              <th class="ths">Percentage</th>
               <td class="tds"><?php echo $app["percentage_on_prod"]."%";?></td>
             </tr>

             <tr>
              <th class="ths">Item Total Price</th>
               <td class="tds"><?php echo $app["total_price"];?></td>
             </tr>

             <tr>
              <th class="ths">Installement Months</th>
               <td class="tds"><?php echo $app["installment_months"];?></td>
             </tr>

             <tr>
              <th class="ths">Monthly Payment</th>
               <td class="tds"><?php echo $app["monthly_payment"];?></td>
             </tr>

             <tr>
              <th class="ths">Advance Payment</th>
               <td class="tds"><?php echo $app["advance_payment"];?></td>
             </tr>

             <tr>
              <th class="ths">Ref By</th>
               <td class="tds"><?php echo $app["ref_by"];?></td>
             </tr>

             <tr>
              <th class="ths">Description</th>
               <td class="tds"><?php echo $app["item_des"];?></td>
             </tr>

            </table>
            
          </div>



            
          </div>
         
        </div>
        </div>

        <hr>

        <h3 class="bg-success rounded" style="padding: 5px 10px;">
            Proof Persons Details
        </h3>

        <?php
        if($proof_person->num_rows > 0){
            while($row = $proof_person->fetch_assoc()){
            ?>
        <div class="jumbotron jumbotron-fluid pl-3" style="padding-top: 10px; padding-bottom:10px">
        <div class="container">
            <div class="row">
            <div class="col-12 pr-5" >

            <table class="" style="width: 100%;  border-collapse: collapse;">
            <tr>
               <th class="ths">Name</th>
               <th class="ths">F-name</th>
               <th class="ths">Mobile</th>
               <th class="ths">CNIC</th>
               <th class="ths">Business Type</th>
               <th class="ths">Business Address</th>
            </tr>

            <tr>
              <td class="tds"><?php echo $row["name"];?></td>
              <td class="tds"><?php echo $row["fname"];?></td>
              <td class="tds"><?php echo $row["mobile"];?></td>
              <td class="tds"><?php echo $row["cnic_no"];?></td>
              <td class="tds"><?php echo $row["business_type"];?></td>
              <td class="tds"><?php echo $row["address"];?></td>
            </tr>
            
            </table>

            </div>

            </div>

            <div class="noprint row mt-3">
            <table class="" style="width: 100%;  border-collapse: collapse;">
            <?php 
            if(!empty($row["image"]) && $row["image"] != "null"){
                ?>
            <tr>
                <div class="col">
                <img onclick="ShowImage(this.src)" class="img-thumbnail" style="height: 200px;" src="../images/proof_person/<?php echo $row["image"]; ?>" alt="">
                <h5 >Profile Image</h5>    
                </div>
            </tr>
            <?php
            } ?>

          <?php 
            if(!empty($row["cnic_image"]) && $row["cnic_image"] != "null"){
                ?>
            <tr>
            <div class="col">
                <img onclick="ShowImage(this.src)" class="img-thumbnail" style="height: 200px;" src="../images/proof_person/<?php echo $row["cnic_image"];?>" alt="">
                <h5>CNIC</h5>
                </div>
            </tr>
            <?php
            } ?>

            <?php 
            if(!empty($row["business_card_image"]) && $row["business_card_image"] != "null"){
                ?>
            <tr>
            <div class="col">
                <img onclick="ShowImage(this.src)" class="img-thumbnail" style="height: 200px;" src="../images/proof_person/<?php echo $row["business_card_image"];?>" alt="">
                <h5 >Business Card</h5>   
                </div>
            </tr>
            <?php
            } ?>
            </table>
            </div>
        </div>
        </div>
            <?php
        }
        }
        ?>

       <div class="noprint">
        <hr>

        <?php 
        if($app["status"] == 3 || $app["status"] == 4){
          ?>
       <h3 class="noprint bg-success rounded " style="padding: 5px 10px;">
            Installment History
        </h3>

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

        <div class="container mt-3 mb-4">
         <div class="row">

           <div class="col">
             <h5 class="d-inline">Total paid amount: </h5>
           </div>

           <div class="col">
             <h5><?php echo $installment["total"];?></h5>
           </div>

           <div class="col">
             <h5 class="d-inline">Remaining amount: </h5>
           </div>

           <div class="col">
             <h5><?php echo ceil($app["total_price"] - $installment["total"]);?></h5>
           </div>

           <div class="col">
             <h5 class="d-inline">No of installment: </h5>
           </div>

           <div class="col">
             <h5><?php echo $installment["count"];?></h5>
           </div>

         </div>
        </div>

        <table class="table table-striped mt-3 mb-3">
                  <thead>
                    <tr>
                      <th style="width: 10px">ID</th>
                      <th>Amount</th>
                      <th>Date</th>
                      <th>Type</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                  $data = DBHelper::get("SELECT * FROM `application_installment` WHERE appID = {$app["id"]}");
                  if ($data->num_rows > 0) {
                      while ($row = $data->fetch_assoc()) {
                          ?>
                          <tr>
                          <td><?php echo $row["id"]; ?></td>
                          <td><?php echo $row["amount"]; ?></td>
                          <td><?php echo $row["date"]; ?></td>
                          <td><span class="badge <?php echo ($row["type"] == 'A') ? "bg-success":"bg-warning"; ?>">
                          <?php echo ($row["type"] == 'A') ? "Advance payment":"Monthly payment"; ?></span></td>
                          <td>
                            <?php if($app["status"] == '3' && $_SESSION["type"] == '1' && $row["type"] != 'A') {  ?>
                            <a href="model/deleteInstallament.php?appID=<?php echo $app["id"]."&ID=".$row["id"];?>" class="btn btn-danger btn-sm">Delete</a>
                            <?php
                             } ?>
                          </td>
                        </tr>
                        <?php
                      }
                  }
                  ?>

                  </tbody>
                </table>

                <a class="btn btn-outline-warning" href="print_installement?ID=<?php echo $app["id"];?>">Print Installment History</a>

                <?php if(ceil($app["total_price"] - $installment["total"]) > 0) { ?>
                <div class="mt-3 mb-2 border border-success rounded">
                <form method="post" class="form-inline p-3" action="model/CustomerDiscount">
                    <input type="hidden" name="appID" value="<?php echo $app["id"];?>">
                    <div class="form-group mb-2">
                     <p style="padding-top: 10px;"><b>Discount To Customer</b></p>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                      <label for="inputPassword2" class="sr-only">Password</label>
                      <input required name="amount" type="number" class="form-control" id="inputPassword2" placeholder="Discount amount">
                    </div>
                    <button type="submit" class="btn btn-outline-success mb-2">Submit</button>
                  </form>
                </div>

        <?php
                }
        }
        ?>
        </div>


        <div class="sign container mt-2">
         <div class="row">
           <div class="col"><p>Customer Sign:________________________</p></div>
           <div class="col"><p>Admin Sign:________________________</p></div>
           <div class="col"><p>Date: <span style="border-bottom:1px solid #000;"><?php echo date('d-m-Y');?></span></p></div>
         </div>
        </div>

        <?php
        if($app["status"] == 4 || $app["status"] == 3){
          $invester = DBHelper::get("select * from investor where id = {$app["investorID"]}")->fetch_assoc();
          ?>
        <div class="noprint mt-5 mb-5">
        <h3 class="noprint bg-success rounded " style="padding: 5px 10px;">
            Investor details
        </h3>

        <!-- *************** Investor account **************-->
        <div class="spg jumbotron jumbotron-fluid pl-3" style="padding-top: 10px; padding-bottom:10px">
        <div class="container">
            <div class="row">
            <div class="col-8" >

            <table class=" mt-4" style="width: 100%;  border-collapse: collapse;">
            <tr>
             <th class="ths">Name</th>
            <th class="ths">Name</th>
            <th class="ths">Mobile</th>
            <th class="ths">CNIC</th>
            <th class="ths">Address</th>
            </tr>

            <tr>
                <td class="tds"><?php echo $invester["id"];?></td>
                <td class="tds"><?php echo $invester["name"];?></td>
                <td class="tds"><?php echo $invester["mobile"];?></td>
                <td class="tds"><?php echo $invester["cnic"];?></td>
                <td class="tds"><?php echo $invester["address"];?></td>
            </tr>

            </table>

            </div>

            <div class="col-4 text-center">
             <img onclick="ShowImage(this.src)" style="width: 250px;" src="../images/investor/<?php echo $invester["image"];?>" alt="">
             </div>
            </div>
        </div>
        </div>

        </div>

        <div class="noprint mt-3 mb-3">
        <h3 class="noprint bg-success rounded " style="padding: 5px 10px;">
            Delivery image
        </h3>
        <img onclick="ShowImage(this.src)" style="width: 300px;" src="../images/application/<?php echo $app["delivery_image"];?>" alt="">
        </div>
          <?php
        }
        ?>


        <h3 class="noprint bg-success rounded " style="padding: 5px 10px;">
            Actions
        </h3>


        <form style="display: none;" id="rejectForm" class="noprint" action="model/rejectApp" method="post">
          <input type="hidden" name="ID" value="<?php echo $app["id"]; ?>">
        <div class="form-group">
          <label for="exampleFormControlTextarea1">Reasion For Rejection</label>
          <textarea required name="des" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Enter rejection comment..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Rejection Form</button>
        </form>


        <form style="display: none;" id="acceptApplication" class="noprint" action="model/changeStatusToActive" method="post">
          <input type="hidden" name="ID" value="<?php echo $app["id"]; ?>">
        <div class="form-group">
          <label>Advance Amount</label>
          <input required type="number" name="amount" class="form-control" placeholder="Enter advance payment" value="<?php echo $app["advance_payment"];?>">
        </div>
        <button type="submit" class="btn btn-warning">Accept Application</button>
        </form>

          
         <div class="noprint mt-3 mb-3">
           <?php
           if($app["status"] == 0 || $app["status"] == 1){
             ?>
               <a href="model/deleteApplication?ID=<?php echo $app["id"];?>" class="btn btn-outline-danger">Delete Application</a>
             <?php
           }
           if($app["status"] != 5){
           ?>
           
           <button onclick="Prints()" class="btn btn-outline-info ml-2">Print Application</button>
          
          <?php
           }
           if($app["status"] == 0 && $_SESSION["type"] == '1'){
             ?>
               <button onclick="AcceptApplication()" class="btn btn-outline-warning ml-2">Accept application</button>
             <?php
           }
           elseif($app["status"] == 1 && $app["advance_payment_status"] == '1'){
            ?>
              <a href="deliver_application?ID=<?php echo $app["id"]?>" class="btn btn-outline-warning ml-2">Deliver application</a>
            <?php
           }
           ?>

           <?php
           if($app["status"] == 0){
            ?>
            <button onclick="RejectionAppp()"  class="btn btn-danger ml-2">Reject Applicationn</button>
          <?php
           }
           ?>

           <?php
           if($app["status"] == 3){
             if($installment["total"] == $app["total_price"]){
               ?>
                <a href="complete_application?ID=<?php echo $app["id"]?>" class="btn btn-warning ml-2">Complete application</a>
               <?php
             }
             else{
              ?>
              <button class="btn btn-outline-dark ml-2" data-toggle="modal" data-target="#installment">Add installment</button>
              <?php
             }
             ?>
           
             <?php
           }
           ?>

         <?php
           if($app["advance_payment_status"] == '0'){
             ?>
               <a href="model/fullPaidAdvancePayment?ID=<?php echo $app["id"];?>" class="btn btn-outline-warning ml-2">Fully Paid Advance Payment</a>
             <?php
           }
           ?>

          <!-- Modal -->
          <div class="modal fade" id="installment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Add monthly installment</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                
                <form method="post" action="model/monthly_installment.php">
               
                    <div class="form-group">
                      <label for="exampleInputEmail1">Amount</label>
                      <input name="amount" required type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $app["monthly_payment"];?>" placeholder="Enter amount...">
                    </div>

                    <input type="hidden" name="appID" value="<?php echo $app["id"];?>">
                   
                    <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                </form>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

       
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
   function ShowImage(value){
    let image = $("#imageView");
    image.prop("src",value);
    $('#imageModel').modal({
    keyboard: false,
    show: true
    })
   }

   function Prints(){
     window.print();
   }

   function RejectionAppp(){
     var rejectForm = $("#rejectForm");
     if(rejectForm.css("display").trim() == "none"){
      rejectForm.show();
     }
     else{
       rejectForm.hide();
     }
   }

   function AcceptApplication(){
    var rejectForm = $("#acceptApplication");
     if(rejectForm.css("display").trim() == "none"){
      rejectForm.show();
     }
     else{
       rejectForm.hide();
     }
   }

</script>