<?php
session_start();
include("../../include/conn.php");
include("../../include/DBHelper.php");
include("../../include/Encryption.php");
include("../../include/HelperFunction.php");

if(isset($_GET["ID"]) && isset($_GET["adminID"])){

 $tranID = $_GET["ID"];
 $adminID = $_GET["adminID"];
 $company_id = $_SESSION["company_id"];

 $tran_data = DBHelper::get("SELECT * FROM `admin_transaction` WHERE id = {$tranID} and adminID = {$adminID}");
 $adminAccount = DBHelper::get("SELECT amount FROM `admin_account` WHERE `adminID` = {$adminID} and company_id = $company_id")->fetch_assoc();
 $adminAccount = $adminAccount["amount"];

 $company_account = DBHelper::get("SELECT * FROM `company_account` WHERE id = $company_id");
 $balance = $company_account->fetch_assoc()["amount"];

 if($balance <  $adminAccount &&
  (($tran_data["status"] == 1) ||
   ($tran_data["exp_type"] == 0 && $tran_data["type"] == "expence"))){
   ?>
   <script>
       var id = "<?php echo $_GET["adminID"];?>";
       alert("Company does not have enough balance to perform this transcation");
       location.replace("../adminProfile?ID="+id);
   </script>
   <?php
   exit;
 }
 
 if($adminAccount > 0) {
 if($tran_data->num_rows > 0){
 $tran_data = $tran_data->fetch_assoc();
 $check = false;
 $amount = $tran_data["amount"];

 if($tran_data["type"] == "investor"){
    if($tran_data["status"] == 0){
        DBHelper::set("UPDATE admin_transaction SET paymentStatus = 1 WHERE id = {$tran_data["id"]} and company_id = $company_id");
        DBHelper::set("UPDATE admin_account SET amount = amount - {$amount} WHERE adminID = {$adminID} and amount > 0 and company_id = $company_id");
        DBHelper::set("UPDATE company_account SET amount = amount + {$amount} where id = $company_id;");
        $check = true;
    }
    elseif($tran_data["status"] == 1){
        DBHelper::set("UPDATE admin_transaction SET paymentStatus = 1 WHERE id = {$tran_data["id"]} and company_id = $company_id");
        DBHelper::set("UPDATE admin_account SET amount = amount - {$amount} WHERE adminID = {$adminID} and company_id = $company_id");
        DBHelper::set("UPDATE company_account SET amount = amount - {$amount} where id = $company_id;");
        $check = true;
    }
    else{
        $check = false;
    }
    
 }

 elseif($tran_data["type"] == "dbs_shop"){
    DBHelper::set("UPDATE admin_transaction SET paymentStatus = 1 WHERE id = {$tran_data["id"]} and company_id = $company_id");
    DBHelper::set("UPDATE admin_account SET amount = amount - {$amount} WHERE adminID = {$adminID} and company_id = $company_id");
    DBHelper::set("UPDATE dbs_shop_account SET balance = balance + {$amount} where status = 0 and company_id = $company_id");
    $check = true;
 }

 elseif($tran_data["type"] == "customer"){
    DBHelper::set("UPDATE admin_transaction SET paymentStatus = 1 WHERE id = {$tran_data["id"]} and company_id = $company_id");
    DBHelper::set("UPDATE admin_account SET amount = amount - {$amount} WHERE adminID = {$adminID} and company_id = $company_id");
    DBHelper::set("UPDATE company_account SET amount = amount + {$amount} where id = $company_id;;");
    $check = true;
 }
 elseif($tran_data["type"] == "expence"){
   DBHelper::set("UPDATE admin_transaction SET paymentStatus = 1 WHERE id = {$tran_data["id"]} and company_id = $company_id");
   DBHelper::set("UPDATE admin_account SET amount = amount - {$amount} WHERE adminID = {$adminID} and company_id = $company_id;");
 
   if($tran_data["exp_type"] == 0){
      DBHelper::set("UPDATE company_account SET amount = amount - {$amount} where id = $company_id;");
   }
   else{
      DBHelper::set("UPDATE dbs_shop_account SET balance = balance - {$amount} WHERE status = 0 and company_id = $company_id");
   }

   $check = true;
 }
 else{
     $check = false;
 }

 if($check){
    ?>
    <script>
         var id = "<?php echo $_GET["adminID"];?>";
        alert("Action perform successfully");
        location.replace("../adminProfile?ID="+id);
    </script>
    <?php
 }
 else{
    ?>
    <script>
         var id = "<?php echo $_GET["adminID"];?>";
        alert("Invalid transaction type");
        location.replace("../adminProfile?ID="+id);
    </script>
    <?php
 }
 }
 else{
    ?>
    <script>
         var id = "<?php echo $_GET["adminID"];?>";
        alert("No transaction exist with id");
        location.replace("../adminProfile?ID="+id);
    </script>
    <?php   
 }}
  else{
    ?>
    <script>
         var id = "<?php echo $_GET["adminID"];?>";
        alert("Admin account is zero");
        location.replace("../adminProfile?ID="+id);
    </script>
    <?php   
 }
}
else{
die("Invalid access is not allowed");
}
?>